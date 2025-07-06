<?php
namespace App\Services;
use App\Models\Article;
use Illuminate\Support\Facades\Log;

class Fake
{
    protected $redFlags = [
        // Sensationalism
        '/\b(BREAKING!|URGENT!|SHOCKING!|ALERT!)\b/i',
        '/\b(100% guaranteed|miracle cure|secret remedy|instant results)\b/i',
        '/\b(they don\'t want you to know|mainstream media ignores|hidden truth)\b/i',
        '/\b(click here|share now|go viral|before it\'s deleted)\b/i',
        // Common fake news patterns
        '/\b(conspiracy|cover.?up|false flag|hoax)\b/i',
        '/\b(deep state|agenda|elites|cabal)\b/i',
        // Emotional manipulation
        '/\b(outrageous|disgusting|unbelievable|astonishing)\b/i',
        // Urgency and exclusivity
        '/\b(limited time|exclusive offer|only few left)\b/i'
    ];

    // Common filler words and phrases used by text generators
    protected $fillerPatterns = [
        '/\b(lorem ipsum|dolor sit amet|consectetur adipiscing)\b/i',
        '/\b(placeholder text|sample text|dummy text)\b/i',
        '/\b(this is a test|example content|filler content)\b/i',
        '/\b(random text|generated content|auto-generated)\b/i',
        '/\b(insert text here|add content here|content goes here)\b/i',
    ];

    // Common gibberish patterns
    protected $gibberishPatterns = [
        '/\b[bcdfghjklmnpqrstvwxyz]{4,}\b/i', // Consonant clusters
        '/\b[aeiou]{4,}\b/i', // Vowel clusters
        '/\b\w*[qxz]\w*[qxz]\w*\b/i', // Multiple rare letters
        '/\b\w{15,}\b/', // Extremely long words
    ];

    public function analyzeArticle(Article $article)
    {
        Log::info('Fake News Detector triggered for article: ' . $article->id);
        $analysis = $this->analyze($article->content);
        $titleAnalysis = $this->analyzeTitle($article->title);
        
        // Combine content and title analysis
        $combinedScore = $analysis['score'] + ($titleAnalysis['score'] * 0.3); // Title has 30% weight
        $combinedReasons = array_merge($analysis['reasons'], $titleAnalysis['reasons']);
        
        return [
            'is_fake' => $combinedScore > 40,
            'score' => min(100, round($combinedScore)),
            'reasons' => array_unique($combinedReasons),
            'article_id' => $article->id,
            'title_analysis' => $titleAnalysis,
            'content_quality' => $this->getContentQualityLevel($combinedScore),
        ];
    }

    public function analyze($content)
    {
        $score = 0;
        $reasons = [];

        // Original red flag checks
        foreach ($this->redFlags as $pattern) {
            if (preg_match($pattern, $content, $matches)) {
                $score += 10;
                $reasons[] = 'Suspicious phrase detected: "' . $matches[0] . '"';
            }
        }

        // Check for filler/placeholder content
        foreach ($this->fillerPatterns as $pattern) {
            if (preg_match($pattern, $content, $matches)) {
                $score += 25; // High penalty for placeholder content
                $reasons[] = 'Placeholder/filler content detected: "' . $matches[0] . '"';
            }
        }

        // Check for gibberish content
        $gibberishScore = $this->checkGibberish($content);
        if ($gibberishScore > 0) {
            $score += $gibberishScore;
            $reasons[] = 'Gibberish or low-quality text detected';
        }

        // Check sentence structure quality
        $sentenceQuality = $this->analyzeSentenceStructure($content);
        if ($sentenceQuality['score'] > 0) {
            $score += $sentenceQuality['score'];
            $reasons = array_merge($reasons, $sentenceQuality['reasons']);
        }

        // Check for repetitive content
        $repetitionScore = $this->checkRepetition($content);
        if ($repetitionScore > 0) {
            $score += $repetitionScore;
            $reasons[] = 'Excessive repetition detected';
        }

        // Check word frequency distribution
        $wordDistribution = $this->analyzeWordDistribution($content);
        if ($wordDistribution['score'] > 0) {
            $score += $wordDistribution['score'];
            $reasons = array_merge($reasons, $wordDistribution['reasons']);
        }

        // Check ALL CAPS words
        if (preg_match_all('/\b[A-Z]{4,}\b/', $content, $matches)) {
            $capCount = count($matches[0]);
            $score += min(20, $capCount * 3); // Max 20 points for caps
            $reasons[] = 'Excessive capitalization (' . $capCount . ' instances)';
        }

        // Check excessive punctuation
        if (preg_match_all('/!{2,}|\?{2,}/', $content, $matches)) {
            $punctCount = count($matches[0]);
            $score += min(15, $punctCount * 2); // Max 15 points
            $reasons[] = 'Excessive punctuation (' . $punctCount . ' instances)';
        }

        // Check for claims without sources
        if (
            preg_match('/\b(studies show|research proves|experts say)\b/i', $content) &&
            !preg_match('/\b(according to|as reported by|source:)\b/i', $content)
        ) {
            $score += 15;
            $reasons[] = 'Unsubstantiated claims without proper sourcing';
        }

        return [
            'score' => max(0, min(100, $score)), // Keep score between 0-100
            'is_fake' => $score > 40, // Higher threshold
            'reasons' => array_unique($reasons) // Remove duplicates
        ];
    }

    protected function checkGibberish($content)
    {
        $score = 0;
        $words = str_word_count($content, 1);
        $totalWords = count($words);
        $gibberishCount = 0;

        if ($totalWords === 0) return 20; // Empty content is suspicious

        foreach ($words as $word) {
            foreach ($this->gibberishPatterns as $pattern) {
                if (preg_match($pattern, $word)) {
                    $gibberishCount++;
                    break;
                }
            }
        }

        $gibberishRatio = $gibberishCount / $totalWords;
        
        if ($gibberishRatio > 0.1) { // More than 10% gibberish
            $score += min(30, $gibberishRatio * 100);
        }

        return $score;
    }

    protected function analyzeSentenceStructure($content)
    {
        $score = 0;
        $reasons = [];
        
        // Split into sentences
        $sentences = preg_split('/[.!?]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
        $totalSentences = count($sentences);
        
        if ($totalSentences === 0) {
            return ['score' => 25, 'reasons' => ['No proper sentences found']];
        }

        $problematicSentences = 0;
        $avgWordsPerSentence = 0;
        $totalWords = 0;

        foreach ($sentences as $sentence) {
            $sentence = trim($sentence);
            $words = str_word_count($sentence, 1);
            $wordCount = count($words);
            $totalWords += $wordCount;

            // Check for extremely short or long sentences
            if ($wordCount < 3) {
                $problematicSentences++;
            } elseif ($wordCount > 50) {
                $problematicSentences++;
            }

            // Check for sentences without proper structure
            if (!preg_match('/\b(the|a|an|this|that|these|those|i|you|we|they|he|she|it)\b/i', $sentence)) {
                $problematicSentences++;
            }
        }

        $avgWordsPerSentence = $totalWords / $totalSentences;
        $problematicRatio = $problematicSentences / $totalSentences;

        if ($problematicRatio > 0.3) { // More than 30% problematic sentences
            $score += min(25, $problematicRatio * 50);
            $reasons[] = 'Poor sentence structure detected';
        }

        if ($avgWordsPerSentence < 5 || $avgWordsPerSentence > 40) {
            $score += 10;
            $reasons[] = 'Unusual sentence length patterns';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    protected function checkRepetition($content)
    {
        $words = str_word_count(strtolower($content), 1);
        $totalWords = count($words);
        
        if ($totalWords < 10) return 0;

        $wordFreq = array_count_values($words);
        $maxFreq = max($wordFreq);
        $repetitionRatio = $maxFreq / $totalWords;

        // Check for excessive repetition of single words
        if ($repetitionRatio > 0.15) { // More than 15% repetition
            return min(20, $repetitionRatio * 100);
        }

        return 0;
    }

    protected function analyzeWordDistribution($content)
    {
        $score = 0;
        $reasons = [];
        
        $words = str_word_count(strtolower($content), 1);
        $totalWords = count($words);
        
        if ($totalWords < 10) {
            return ['score' => 15, 'reasons' => ['Content too short for analysis']];
        }

        // Check for very limited vocabulary
        $uniqueWords = array_unique($words);
        $vocabularyRatio = count($uniqueWords) / $totalWords;
        
        if ($vocabularyRatio < 0.3) { // Less than 30% unique words
            $score += 15;
            $reasons[] = 'Limited vocabulary detected';
        }

        // Check for unusual character patterns
        $specialCharCount = preg_match_all('/[^a-zA-Z0-9\s\.\,\!\?\-\(\)\[\]\{\}]/', $content);
        if ($specialCharCount > ($totalWords * 0.1)) {
            $score += 10;
            $reasons[] = 'Unusual character patterns detected';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    protected function analyzeTitle($title)
    {
        $score = 0;
        $reasons = [];

        // Original title analysis
        foreach ($this->redFlags as $pattern) {
            if (preg_match($pattern, $title, $matches)) {
                $score += 15; // Higher weight for title flags
                $reasons[] = 'Sensational title: "' . $matches[0] . '"';
            }
        }

        // Check for gibberish in title
        $gibberishScore = $this->checkGibberish($title);
        if ($gibberishScore > 0) {
            $score += $gibberishScore;
            $reasons[] = 'Gibberish detected in title';
        }

        // Check for filler content in title
        foreach ($this->fillerPatterns as $pattern) {
            if (preg_match($pattern, $title, $matches)) {
                $score += 20;
                $reasons[] = 'Placeholder title detected: "' . $matches[0] . '"';
            }
        }

        return [
            'score' => $score,
            'reasons' => $reasons
        ];
    }

    protected function getContentQualityLevel($score)
    {
        if ($score >= 70) return 'Very Poor';
        if ($score >= 50) return 'Poor';
        if ($score >= 30) return 'Questionable';
        if ($score >= 15) return 'Fair';
        return 'Good';
    }
}