import json
from sqlalchemy import create_engine
import pandas as pd
from mlxtend.frequent_patterns import apriori, association_rules
from mlxtend.preprocessing import TransactionEncoder

# CONNECT DB
username = "root"
password = "MySQLPASSWORD25"
host = "127.0.0.1"
port = 3306
database = "techboxx"

# ---------- DB CONNECTION ----------
engine = create_engine(f"mysql+pymysql://{username}:{password}@{host}:{port}/{database}")

# ---------- BUILD LOOKUP MAPS ----------
# CPU
cpu_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM cpus", engine)
cpu_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in cpu_df.itertuples()}

# GPU
gpu_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM gpus", engine)
gpu_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in gpu_df.itertuples()}

# RAM
ram_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM rams", engine)
ram_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in ram_df.itertuples()}

# Motherboard
mobo_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM motherboards", engine)
mobo_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in mobo_df.itertuples()}

# PSU
psu_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM psus", engine)
psu_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in psu_df.itertuples()}

# Case
case_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM pc_cases", engine)
case_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in case_df.itertuples()}

# Cooler
cooler_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM coolers", engine)
cooler_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in cooler_df.itertuples()}

# Storage
storage_df = pd.read_sql("SELECT id, brand, model, build_category_id FROM storages", engine)
storage_map = {row.id: f"{row.brand} {row.model} {row.build_category_id}" for row in storage_df.itertuples()}

lookup_maps = {
    "cpu": cpu_map,
    "gpu": gpu_map,
    "ram": ram_map,
    "psu": psu_map,
    "cooler": cooler_map,
    "motherboard": mobo_map,
    "pc_case": case_map,
    "storage": storage_map
}

# ---------- CREATE CATEGORY LOOKUP MAPS ----------
component_to_category = {}
component_to_brand = {}  # New: track component brands

for comp_type, comp_map in lookup_maps.items():
    for comp_id, comp_info in comp_map.items():
        # Extract category from the string (it's at the end after the last space)
        parts = comp_info.split()
        category_id = int(parts[-1])
        brand = parts[0]  # First part is the brand
        
        component_to_category[f"{comp_type}_id:{comp_id}"] = category_id
        component_to_brand[f"{comp_type}_id:{comp_id}"] = brand

# ---------- LOAD USER BUILDS ----------
query = "SELECT * FROM user_builds"
df = pd.read_sql(query, engine)

transactions = []
for _, row in df.iterrows():
    items = []
    for col in ["pc_case_id", "motherboard_id", "cpu_id", "gpu_id", "storage_id", "ram_id", "psu_id", "cooler_id"]:
        if pd.notna(row[col]):
            items.append(f"{col}:{row[col]}")
    transactions.append(items)

# ---------- APRIORI ----------
te = TransactionEncoder()
te_ary = te.fit(transactions).transform(transactions)
basket = pd.DataFrame(te_ary, columns=te.columns_)

frequent_itemsets = apriori(basket, min_support=0.01, use_colnames=True)
rules = association_rules(frequent_itemsets, metric="confidence", min_threshold=0.6)

# ---------- GROUP BY BUILD CATEGORY ----------
def get_best_recommendation_by_category():
    # Get all possible component combinations from frequent itemsets
    component_types = ["pc_case_id", "motherboard_id", "cpu_id", "gpu_id", "storage_id", "ram_id", "psu_id", "cooler_id"]
    
    # Score each build category based on frequent itemsets
    category_scores = {}
    
    for _, itemset_row in frequent_itemsets.iterrows():
        itemset = itemset_row['itemsets']
        support = itemset_row['support']
        
        # Get categories for items in this itemset
        categories_in_set = []
        for item in itemset:
            if item in component_to_category:
                categories_in_set.append(component_to_category[item])
        
        if categories_in_set:
            # If all items in the set are from the same category, boost that category's score
            unique_categories = set(categories_in_set)
            for category in unique_categories:
                if category not in category_scores:
                    category_scores[category] = 0
                # Weight by support and how "pure" the category is in this itemset
                category_purity = categories_in_set.count(category) / len(categories_in_set)
                category_scores[category] += support * category_purity
    
    # Find the best category
    if not category_scores:
        return get_fallback_recommendations()
    
    # TWEAK HERE: Force a specific category for testing
    # Uncomment one of these lines to override the automatic selection:
    # best_category = 1  # Force category 1
    # best_category = 3  # Force category 3
    
    # Original automatic selection (comment this out if forcing a category above)
    best_category = max(category_scores, key=category_scores.get)
    
    # DEBUG: Print category information
    print(f"Available categories and scores: {category_scores}")
    print(f"Selected category: {best_category}")
    
    # Now get the best component for each type within this category
    recommendations = {}
    
    # TWEAK HERE: Force specific CPU brand
    # Uncomment one of these to force a CPU brand:
    preferred_cpu_brand = "AMD"    # Force AMD CPUs
    # preferred_cpu_brand = "Intel"  # Force Intel CPUs
    # preferred_cpu_brand = None  # Use automatic selection
    
    for col in component_types:
        comp_type = col.replace("_id", "")
        
        # Find frequent items of this component type that belong to the best category
        category_items = []
        
        for _, itemset_row in frequent_itemsets.iterrows():
            itemset = itemset_row['itemsets']
            support = itemset_row['support']
            
            for item in itemset:
                if item.startswith(col) and item in component_to_category:
                    if component_to_category[item] == best_category:
                        # Special handling for CPU brand filtering
                        if comp_type == "cpu" and preferred_cpu_brand:
                            if item in component_to_brand:
                                item_brand = component_to_brand[item]
                                if item_brand.lower() != preferred_cpu_brand.lower():
                                    continue  # Skip this CPU, wrong brand
                        
                        category_items.append((item, support))
        
        if category_items:
            # Pick the one with highest support
            best_item = max(category_items, key=lambda x: x[1])[0]
            comp, comp_id = best_item.split(":")
            comp_id = int(comp_id)
            
            # Get human-readable name without the category suffix
            full_name = lookup_maps[comp_type].get(comp_id, f"Unknown {comp_id}")
            # Remove the category number from the end
            clean_name = " ".join(full_name.split()[:-1])
            recommendations[comp_type] = clean_name
        else:
            # Fallback: get any item of this type from the best category
            if comp_type == "cpu" and preferred_cpu_brand:
                fallback_item = get_fallback_for_component_with_brand(comp_type, best_category, preferred_cpu_brand)
            else:
                fallback_item = get_fallback_for_component(comp_type, best_category)
            recommendations[comp_type] = fallback_item
    
    return recommendations

def get_recommendations_for_category(target_category, preferred_cpu_brand=None):
    """Get recommendations for a specific category (useful for testing)"""
    recommendations = {}
    component_types = ["pc_case_id", "motherboard_id", "cpu_id", "gpu_id", "storage_id", "ram_id", "psu_id", "cooler_id"]
    
    print(f"Searching for components in category {target_category}...")
    if preferred_cpu_brand:
        print(f"Forcing CPU brand: {preferred_cpu_brand}")
    
    for col in component_types:
        comp_type = col.replace("_id", "")
        
        # Find frequent items of this component type that belong to the target category
        category_items = []
        
        for _, itemset_row in frequent_itemsets.iterrows():
            itemset = itemset_row['itemsets']
            support = itemset_row['support']
            
            for item in itemset:
                if item.startswith(col) and item in component_to_category:
                    if component_to_category[item] == target_category:
                        # Special handling for CPU brand filtering
                        if comp_type == "cpu" and preferred_cpu_brand:
                            if item in component_to_brand:
                                item_brand = component_to_brand[item]
                                if item_brand.lower() != preferred_cpu_brand.lower():
                                    continue  # Skip this CPU, wrong brand
                        
                        category_items.append((item, support))
        
        if category_items:
            # Pick the one with highest support
            best_item = max(category_items, key=lambda x: x[1])[0]
            comp, comp_id = best_item.split(":")
            comp_id = int(comp_id)
            
            # Get human-readable name without the category suffix
            full_name = lookup_maps[comp_type].get(comp_id, f"Unknown {comp_id}")
            clean_name = " ".join(full_name.split()[:-1])
            recommendations[comp_type] = clean_name
            print(f"  {comp_type}: Found {clean_name}")
        else:
            # Fallback: get any item of this type from the target category
            if comp_type == "cpu" and preferred_cpu_brand:
                fallback_item = get_fallback_for_component_with_brand(comp_type, target_category, preferred_cpu_brand)
            else:
                fallback_item = get_fallback_for_component(comp_type, target_category)
            recommendations[comp_type] = fallback_item
            print(f"  {comp_type}: Used fallback {fallback_item}")
    
    return recommendations

def get_fallback_for_component_with_brand(comp_type, target_category, preferred_brand):
    """Get any component of the given type from the target category with specific brand"""
    comp_map = lookup_maps[comp_type]
    for comp_id, comp_info in comp_map.items():
        parts = comp_info.split()
        category_id = int(parts[-1])
        brand = parts[0]
        
        if category_id == target_category and brand.lower() == preferred_brand.lower():
            return " ".join(parts[:-1])  # Remove category number
    
    # If no match found with preferred brand, fall back to any brand in the category
    print(f"Warning: No {preferred_brand} {comp_type} found in category {target_category}, using any brand")
    return get_fallback_for_component(comp_type, target_category)

def get_fallback_for_component(comp_type, target_category):
    """Get any component of the given type from the target category"""
    comp_map = lookup_maps[comp_type]
    for comp_id, comp_info in comp_map.items():
        category_id = int(comp_info.split()[-1])
        if category_id == target_category:
            return " ".join(comp_info.split()[:-1])  # Remove category number
    return None

def get_fallback_recommendations():
    """Original logic as fallback"""
    recommendations = {}
    component_types = ["pc_case_id", "motherboard_id", "cpu_id", "gpu_id", "storage_id", "ram_id", "psu_id", "cooler_id"]
    
    for col in component_types:
        filtered = frequent_itemsets[frequent_itemsets['itemsets'].astype(str).str.contains(col)]
        
        if not filtered.empty:
            top_item = filtered.sort_values("support", ascending=False).iloc[0]
            item = list(top_item['itemsets'])[0]
            comp, comp_id = item.split(":")
            comp_type = comp.replace("_id", "")
            comp_id = int(comp_id)
            
            full_name = lookup_maps[comp_type].get(comp_id, f"Unknown {comp_id}")
            clean_name = " ".join(full_name.split()[:-1])
            recommendations[comp_type] = clean_name
        else:
            recommendations[col.replace("_id", "")] = None
    
    return recommendations

# ---------- GET RECOMMENDATIONS ----------
# ALTERNATIVE: Test specific categories with CPU brand preferences
# test_scenarios = [
#     (2, "AMD"),    # Category 2 with AMD CPU
#     (2, "Intel"),  # Category 2 with Intel CPU
#     (1, "AMD"),    # Category 1 with AMD CPU
#     (3, "Intel"),  # Category 3 with Intel CPU
# ]
# for test_cat, cpu_brand in test_scenarios:
#     print(f"\n=== TESTING CATEGORY {test_cat} WITH {cpu_brand} CPU ===")
#     recommendations = get_recommendations_for_category(test_cat, cpu_brand)
#     print(json.dumps(recommendations, indent=4, ensure_ascii=False))

recommendations = get_best_recommendation_by_category()

# ---------- OUTPUT JSON ----------
print(json.dumps(recommendations, indent=4, ensure_ascii=False))