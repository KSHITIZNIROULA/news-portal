@extends('admin.dashboard')
@section('content')

    <div class="container mx-auto p-6 max-w-6xl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Fake News Detection</h1>
        </div>

        @if ($articles->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No articles available</h3>
                <p class="mt-1 text-gray-500">When articles are published, they'll appear here for verification.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($articles as $article)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                        <!-- Article Thumbnail -->
                        <div class="h-48 bg-gray-100 relative overflow-hidden">
                            @if ($article->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $article->images->first()->path) }}"
                                    alt="{{ $article->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Article Content -->
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                    <a href="{{ route('articles.show', $article->slug) }}"
                                        class="hover:text-blue-600">{{ $article->title }}</a>
                                </h3>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-3">
                                <span class="mr-3">{{ $article->category->name }}</span>
                                <span>•</span>
                                <span class="ml-3">{{ $article->author->name }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not published' }}
                                </span>
                                <button onclick="openAnalysisModal({{ $article->id }}, @js($article->title))"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                    Check for Fake News
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    <!-- Analysis Modal -->
    <div id="analysisModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal content -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Analyzing: <span
                            id="articleTitle"></span></h3>

                    <!-- Progress bar -->
                    <div class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="analysisProgress" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                        <p id="progressText" class="text-sm text-gray-500 mt-1">Starting analysis...</p>
                    </div>

                    <!-- Results section -->
                    <div id="resultsContainer" class="hidden">
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg id="resultIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <!-- Icon will be dynamically changed -->
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p id="resultTitle" class="text-sm font-medium"></p>
                                    <div id="resultDetails" class="mt-1 text-sm text-gray-500 space-y-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button onclick="closeModal()" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    function openAnalysisModal(articleId, title) {


        const modal = document.getElementById('analysisModal');
        document.getElementById('articleTitle').textContent = title;
        modal.classList.remove('hidden');

        // Start with 0% progress
        updateProgress(0, "Starting analysis...");

        // Show loading state
        document.getElementById('resultsContainer').classList.add('hidden');

        // Simulate progress updates while waiting for API
        const progressInterval = setInterval(() => {
            const current = parseInt(document.getElementById('analysisProgress').style.width) || 0;
            if (current < 90) {
                updateProgress(current + 10, getProgressMessage(current + 10));
            }
        }, 500);

        // Start actual analysis
        analyzeArticle(articleId).finally(() => {
            clearInterval(progressInterval);
        });
    }

    function getProgressMessage(percent) {
        const messages = [{
                range: [0, 20],
                text: "Initializing analysis..."
            },
            {
                range: [21, 40],
                text: "Checking for sensational language..."
            },
            {
                range: [41, 60],
                text: "Verifying sources..."
            },
            {
                range: [61, 80],
                text: "Comparing with known patterns..."
            },
            {
                range: [81, 99],
                text: "Finalizing results..."
            }
        ];

        const found = messages.find(m => percent >= m.range[0] && percent <= m.range[1]);
        return found ? found.text : "Processing...";
    }

    function closeModal() {
        document.getElementById('analysisModal').classList.add('hidden');
        resetModal();
    }

    function resetModal() {
        document.getElementById('analysisProgress').style.width = '0%';
        document.getElementById('progressText').textContent = 'Starting analysis...';
        document.getElementById('resultsContainer').classList.add('hidden');
    }


    function updateProgress(percent, text) {
        document.getElementById('analysisProgress').style.width = percent + '%';
        document.getElementById('progressText').textContent = text;
    }

    function analyzeArticle(articleId) {
        fetch(`/admin/fake/${articleId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                updateProgress(100, "Analysis complete!");
                showResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                updateProgress(100, "Analysis failed!");

                // New fallback UI logic
                const resultsContainer = document.getElementById('resultsContainer');
                const resultTitle = document.getElementById('resultTitle');
                const resultDetails = document.getElementById('resultDetails');
                const resultIcon = document.getElementById('resultIcon');

                resultTitle.textContent = 'Error during analysis';
                resultDetails.innerHTML =
                    '<p class="text-red-500">Something went wrong. Please try again later.</p>';
                resultIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />';
                resultIcon.classList.add('text-red-500');

                resultsContainer.classList.remove('hidden');
            });
    }

    // ✅ Define globally, after all utility functions
    function showResults(data) {
        const resultsContainer = document.getElementById('resultsContainer');
        const resultTitle = document.getElementById('resultTitle');
        const resultDetails = document.getElementById('resultDetails');
        const resultIcon = document.getElementById('resultIcon');

        if (data.truth_score < 40) {
            resultTitle.textContent = 'Low Credibility Content';
            resultIcon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            resultIcon.classList.add('text-red-500');
        } else if (data.truth_score < 70) {
            resultTitle.textContent = 'Questionable Content';
            resultIcon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            resultIcon.classList.add('text-yellow-500');
        } else {
            resultTitle.textContent = 'Credible Content';
            resultIcon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
            resultIcon.classList.add('text-green-500');
        }

        let reasonsHtml = '';
        data.reasons.forEach(reason => {
            reasonsHtml += `<p class="text-sm">• ${reason}</p>`;
        });

        resultDetails.innerHTML = `
        <p class="font-medium">Credibility Score: ${data.truth_score}%</p>
        <div class="mt-2">${reasonsHtml}</div>
    `;

        resultsContainer.classList.remove('hidden');
    }
</script>
