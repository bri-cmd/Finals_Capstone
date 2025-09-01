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

# CREATE SQLALCHEMY 
engine = create_engine(f"mysql+pymysql://{username}:{password}@{host}:{port}/{database}")

# LOAD USER BUILD TABLE
query = "SELECT user_id, build_name, case_id, mobo_id, cpu_id, storage_id, ram_id, psu_id, cooler_id FROM user_builds"
df = pd.read_sql(query, engine)

# MBA
transactions = []
for _, row in df.iterrows():
    items = []
    for col in ["case_id", "mobo_id", "cpu_id", "storage_id", "ram_id", "psu_id", "cooler_id"]:
        if pd.notna(row[col]):
            items.append(f"{col}:{row[col]}")
    transactions.append(items)

# TRANSFORMS TO ONE-HOT ENCODING
te = TransactionEncoder()
te_ary = te.fit(transactions).transform(transactions)
basket = pd.DataFrame(te_ary, columns=te.columns_)

# RUN APRIORI
frequent_itemsets = apriori(basket, min_support=0.01, use_colnames=True)

# GENERATE ASSOCIATION RULES
rules = association_rules(frequent_itemsets, metric="confidence", min_threshold=0.6)

# PRINT RULES
print("Frequent Itemsets:")
print(frequent_itemsets.sort_values("support", ascending=False).head(10))

print("\nAssociation Rules:")
print(rules[['antecedents', 'consequents', 'support', 'confidence', 'lift']].head(10))