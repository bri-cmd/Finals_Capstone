<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] ?? 'Product' }} - Techboxx</title>

    {{-- Include same Vite assets as catalogue so header styles & scripts load --}}
    @vite([
        'resources/css/app.css',
        'resources/css/landingpage/header.css',
        'resources/js/app.js',
    ])

    <!-- Font Awesome for user icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gray-100">

    <!-- Fixed site header -->
    <x-landingheader :name="Auth::user()?->first_name" />

    @php
        $mainImage = asset('storage/' . str_replace('\\', '/', $product['image'] ?? 'images/placeholder.png'));
        $thumbs = [$mainImage];
    @endphp

    <main class="max-w-7xl mx-auto px-6 pt-24 pb-12">
        <!-- Breadcrumb -->
        <nav class="text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('catalogue') }}" class="hover:underline">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $product['name'] ?? 'Product' }}</span>
        </nav>

        <!-- TWO COLUMN LAYOUT -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- LEFT: Image box -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-col items-center">
                    <div class="flex-1 flex items-center justify-center">
                        <div x-data='{ main: @json($mainImage), thumbs: @json($thumbs) }' class="w-full">
                            <div class="flex justify-center items-center border rounded-md bg-gray-50 p-6">
                                <img :src="main" alt="{{ $product['name'] ?? 'Product' }}" class="max-h-[420px] object-contain">
                            </div>

                            <!-- Mobile thumbs -->
                            <div class="flex gap-3 mt-4 md:hidden justify-center">
                                <template x-for="(t,i) in thumbs" :key="i">
                                    <button type="button" @click="main = t" class="w-20 h-20 border rounded-md p-1 bg-white">
                                        <img :src="t" class="w-full h-full object-contain">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Product info box -->
            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $product['name'] ?? 'Product' }}</h1>
                <div class="flex items-center gap-3 mt-2">
                    <p class="text-xs uppercase text-gray-500">{{ $product['brand'] ?? 'Unknown Brand' }}</p>
                    <span class="inline-block h-1 w-1 bg-gray-300 rounded-full"></span>
                    <p class="text-xs text-gray-400">{{ ucfirst($product['category'] ?? '') }}</p>
                </div>

                <!-- Ratings -->
                <div class="flex items-center gap-3 mt-4 text-yellow-400">
                    ★★★★☆ <span class="text-sm text-gray-500 ml-2">({{ $reviews->count() }} reviews)</span>
                </div>

                <!-- Short description -->
                <p class="text-gray-700 mt-4 leading-relaxed">
                    {{ Str::limit($product['description'] ?? 'This is a placeholder description.', 120) }}
                </p>
                <a href="#full-description" class="text-blue-600 hover:underline text-sm">
                    See full description
                </a>

                <!-- Price & Stock -->
                <div class="mt-6 border-t pt-6">
                    <p class="text-sm text-gray-500">Price</p>
                    <div class="text-2xl font-bold text-blue-600">₱{{ number_format($product['price'] ?? 0, 0) }}</div>

                    <!-- Stock directly below price -->
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Stock</p>
                        @if(($product['stock'] ?? 0) > 0)
                            <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-sm font-semibold">
                                In stock
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-50 text-red-700 rounded-full text-sm font-semibold">
                                Out of stock
                            </span>
                        @endif
                    </div>

                    <!-- Add to cart -->
                    <form action="{{ route('cart.add') }}" method="POST" class="mt-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <input type="hidden" name="name" value="{{ $product['name'] }}">
                        <input type="hidden" name="price" value="{{ $product['price'] }}">

                        <!-- Quantity dropdown -->
                        <div class="flex items-center gap-3 mt-4">
                            <label class="text-sm text-gray-600">Quantity</label>
                            <div class="relative">
                                <select name="quantity"
                                    class="appearance-none border rounded px-3 pr-8 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    @for($i = 1; $i <= min(10, $product['stock'] ?? 0); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <button type="submit"
                                class="ml-auto px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition"
                                @if(($product['stock'] ?? 0) <= 0) disabled @endif>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Full Description -->
        <div id="full-description" class="mt-12 bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-3">Full Description</h2>
            <p class="text-gray-700 leading-relaxed">
                {{ $product['description'] ?? 'No description available.' }}
            </p>
        </div>

        <!-- Customer Reviews -->
        <div class="mt-12 bg-white shadow rounded-lg p-6">
            <h2 class="text-xl mb-6 text-center">Customer Reviews</h2>

            @php
                $totalReviews = $reviews->count();
                $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 2) : 0;
                $ratingCounts = [
                    5 => $reviews->where('rating', 5)->count(),
                    4 => $reviews->where('rating', 4)->count(),
                    3 => $reviews->where('rating', 3)->count(),
                    2 => $reviews->where('rating', 2)->count(),
                    1 => $reviews->where('rating', 1)->count(),
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center border-b pb-6">
                <!-- Left: Average Rating -->
                <div class="text-center">
                    <div class="text-yellow-400 text-4xl font-bold">
                        {{ str_repeat('★', floor($averageRating)) }}{{ str_repeat('☆', 5 - floor($averageRating)) }}
                    </div>
                    <p class="text-blue-600 font-semibold mt-1">{{ number_format($averageRating, 2) }} out of 5</p>
                    <p class="text-gray-500 text-sm mt-1">Based on {{ $totalReviews }} reviews</p>
                </div>

                <!-- Middle: Rating Breakdown -->
                <div class="border-l border-r px-6"> <!-- added px-6 for more spacing -->
                    @foreach([5,4,3,2,1] as $star)
                        @php
                            $count = $ratingCounts[$star];
                            $percent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                        @endphp
                        <div class="flex items-center mb-2">
                            <!-- Fixed-width star labels to align bars -->
                            <span class="text-yellow-400 text-base font-medium w-24 text-left">
                                {{ str_repeat('★', $star) }}{{ str_repeat('☆', 5 - $star) }}
                            </span>

                            <!-- Bar -->
                            <div class="flex-1 h-3 bg-gray-200 rounded overflow-hidden">
                                <div class="h-3 bg-blue-600" style="width: {{ $percent }}%"></div>
                            </div>

                            <!-- Count -->
                            <span class="ml-3 text-sm text-gray-600 w-6 text-right">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>


                <!-- Right: Write Review Button -->
                <div class="flex justify-center md:justify-start pl-20">
                    <button onclick="document.getElementById('review-form').classList.remove('hidden')"
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
                        Write a review
                    </button>
                </div>
            </div>

            <!-- Review Form -->
            <div id="review-form" class="hidden mt-6 border rounded p-6">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <input type="hidden" name="product_table" value="{{ $product['category'] }}">

                    <!-- Rating -->
                    <label class="block text-sm font-medium mb-2">Rating:</label>
                    <div class="flex items-center mb-4 space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <label>
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                <span class="text-3xl cursor-pointer text-gray-300 peer-checked:text-yellow-400">★</span>
                            </label>
                        @endfor
                    </div>

                    <!-- Title -->
                    <label class="block text-sm font-medium mb-1">Review Title</label>
                    <input type="text" name="title" maxlength="100"
                           class="w-full border rounded px-3 py-2 mb-3">

                    <!-- Content -->
                    <label class="block text-sm font-medium mb-1">Review</label>
                    <textarea name="content" rows="4" class="w-full border rounded px-3 py-2 mb-3"></textarea>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">
                        <button type="button" 
                                onclick="document.getElementById('review-form').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Cancel review
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reviews List -->
            <div class="divide-y mt-8">
                @forelse($reviews as $review)
                    <div class="py-4">
                        <!-- Stars on top -->
                        <p class="text-yellow-400 text-3xl font-bold">
                            {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                        </p>

                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 text-gray-600">
                                    <i class="fas fa-user"></i>
                                </div>
                                <p class="font-semibold">{{ $review->name ?? 'Anonymous' }}</p>
                            </div>
                            <span class="text-sm text-gray-400">
                                {{ $review->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <p class="text-gray-800 font-semibold mt-2">{{ $review->title }}</p>
                        <p class="text-gray-700">{{ $review->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No reviews yet. Be the first to leave one!</p>
                @endforelse
            </div>
        </div>
    </main>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
