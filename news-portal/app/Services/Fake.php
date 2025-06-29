<?php
// app/Services/FakeNewsDetector.php
namespace App\Services;

class Fake 
{
    protected $redFlags = [
        // Sensationalism
        '/\b(BREAKING!|URGENT!|SHOCKING!)\b/i',
        '/\b(100% guaranteed|miracle cure|secret remedy)\b/i',
        '/\b(they don\'t want you to know|mainstream media ignores)\b/i',
        '/\b(click here|share now|virginia|go viral)\b/i',
        
        // Common fake news patterns
        '/\b(conspiracy|cover.?up|false flag)\b/i',
        '/\b(deep state|agenda|elites)\b/i',
    ];

    protected $trustedSources = [
        'reuters.com',
        'bbc.com',
        'apnews.com',
        'nytimes.com',
        'theguardian.com'
    ];

    public function analyze($content, $sourceUrl = null)
    {
        $score = 0;
        $reasons = [];
        
        // Check for red flags in content
        foreach ($this->redFlags as $pattern) {
            if (preg_match($pattern, $content)) {
                $score += 10;
                $reasons[] = 'Contains suspicious phrases: '.$pattern;
            }
        }

        // Check source credibility
        if ($sourceUrl) {
            $isTrusted = false;
            foreach ($this->trustedSources as $trusted) {
                if (strpos($sourceUrl, $trusted) !== false) {
                    $isTrusted = true;
                    break;
                }
            }
            if (!$isTrusted) {
                $score += 20;
                $reasons[] = 'Untrusted news source';
            }
        }

        // Check ALL CAPS words
        if (preg_match('/\b[A-Z]{4,}\b/', $content)) {
            $score += 15;
            $reasons[] = 'Excessive capitalization';
        }

        return [
            'score' => $score,
            'is_fake' => $score > 30, // Threshold
            'reasons' => $reasons
        ];
    }
}