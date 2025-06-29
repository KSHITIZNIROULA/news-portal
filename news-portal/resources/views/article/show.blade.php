@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Article Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <!-- Article Header -->
            <div class="p-6 md:p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $article->title }}</h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 mb-6">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $article->author ? $article->author->name : 'Unknown Author' }}</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>{{ $article->category ? $article->category->name : 'Uncategorized' }}</span>
                    </div>

                    <div class="flex items-center">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($article->status) }}
                        </span>
                    </div>

                    @if ($article->published_at)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $article->published_at->format('M d, Y \a\t H:i') }}</span>
                        </div>
                    @endif

                    @auth
                        @if (!auth()->user()->isSubscribedTo($article->author))
                            <form action="{{ route('esewa.initiate',$article->author_id) }}" method="GET" class="ml-auto">
                                @csrf
                                <button type="submit"
                                    class="flex items-center text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-full transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Subscribe to {{ $article->author->name }}
                                </button>
                            </form>
                        @else
                            <span class="flex items-center text-sm bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Already Subscribed
                            </span>
                            <form action="{{ route('subscriptions.unsubscribe',$article->author) }}" method="POST" class="ml-auto">
                                @csrf
                                <button type="submit"
                                    class="flex items-center text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-full transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Unsubscribe to {{ $article->author->name }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>

                <!-- Article Images -->
                @if ($article->images->isNotEmpty())
                    <div class="mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($article->images as $image)
                                <div class="relative group overflow-hidden rounded-lg shadow-md">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $article->title }} Image"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                                        onclick="openImageModal('{{ asset('storage/' . $image->path) }}')">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                        <button
                                            class="bg-white bg-opacity-80 rounded-full p-2 text-gray-800 hover:bg-opacity-100"
                                            onclick="openImageModal('{{ asset('storage/' . $image->path) }}')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Article Content -->
                <div class="prose max-w-none text-gray-700">
                    {!! $article->content !!}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.articles.index') }}"
                class="flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Articles
            </a>

            @if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::id() === $article->author_id))
                <a href="{{ route('admin.articles.edit', $article) }}"
                    class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Article
                </a>
            @endif
        </div>
    </div>

    <!-- Custom Prose Styles -->
    <style>
        .prose {
            line-height: 1.6;
        }

        .prose h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #1a202c;
        }

        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1.25rem;
            margin-bottom: 0.75rem;
            color: #1a202c;
        }

        .prose p {
            margin-bottom: 1rem;
        }

        .prose ul,
        .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .prose ul {
            list-style-type: disc;
        }

        .prose ol {
            list-style-type: decimal;
        }

        .prose a {
            color: #3182ce;
            text-decoration: underline;
        }

        .prose a:hover {
            color: #2c5282;
        }

        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.375rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        /* Add to your existing styles */
        #imageModal {
            transition: opacity 0.3s ease;
        }

        #imageModal:not(.hidden) {
            display: flex !important;
        }

        #modalImage {
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        #modalImage.zoomed {
            transform: scale(1.5);
            cursor: zoom-out;
        }
    </style>
    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black bg-opacity-75" onclick="closeImageModal()"></div>
        <div class="relative flex items-center justify-center h-full w-full p-4">
            <button class="absolute top-4 right-4 text-white hover:text-gray-300 z-10" onclick="closeImageModal()">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="max-w-4xl max-h-full overflow-auto">
                <img id="modalImage" src="" alt="Full size" class="max-w-full max-h-screen mx-auto">
            </div>
        </div>
    </div>
    <script>
        // Open modal with clicked image
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');

            modal.classList.remove('hidden');
            modalImg.src = imageSrc;
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        // Close modal
        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }

        // Close modal when pressing ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
        // Add this to your existing JavaScript
        document.getElementById('modalImage').addEventListener('click', function() {
            this.classList.toggle('zoomed');
        });
    </script>
@endsection
