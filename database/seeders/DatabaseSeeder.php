<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $blogCategories = collect([
            'Architecture',
            'AI & Innovation',
            'Digital Transformation',
            'Smart Buildings',
            'Real Estate',
            'Business Strategy',
            'E-Learning',
        ])->map(fn ($name, $i) => Category::query()->firstOrCreate(
            ['type' => 'blog', 'slug' => Str::slug($name)],
            ['name' => $name, 'sort_order' => $i]
        ));

        $services = [
            [
                'title' => 'Architecture & Construction Consulting',
                'slug' => 'architecture-construction',
                'short_description' => 'Architectural design, 2D/3D modeling, BIM services, smart buildings, and sustainable construction consulting.',
                'full_description' => 'We provide innovative architectural and construction consulting services that combine creativity, technical precision, and sustainability. Our goal is to help clients design, plan, and implement buildings and environments that are functional, efficient, and future-ready.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Artificial Intelligence & Innovation',
                'slug' => 'artificial-intelligence-innovation',
                'short_description' => 'AI integration, automation, digital transformation, and innovation advisory for modern organizations.',
                'full_description' => 'We help organizations leverage applied artificial intelligence to improve operations, automate processes, generate insights, and unlock new opportunities for growth and innovation.',
                'sort_order' => 2,
            ],
            [
                'title' => 'Digital Services & Technology Solutions',
                'slug' => 'digital-services',
                'short_description' => 'Web platforms, business systems, digital strategy, and technology solutions for growth and efficiency.',
                'full_description' => 'We create digital products and systems that support business efficiency, service delivery, and long-term growth. From websites and platforms to digital transformation strategies, we help organizations thrive in the digital era.',
                'sort_order' => 3,
            ],
            [
                'title' => 'Professional Training & E-Learning',
                'slug' => 'training-elearning',
                'short_description' => 'Professional training, distance education, certification programs, and online learning platform management.',
                'full_description' => 'We design and deliver training programs that build capacity, improve professional skills, and make learning more accessible through digital platforms and distance education.',
                'sort_order' => 4,
            ],
            [
                'title' => 'Real Estate Consulting & Investment Advisory',
                'slug' => 'real-estate-consulting',
                'short_description' => 'Feasibility studies, property consulting, valuation support, and investment guidance.',
                'full_description' => 'We support clients in making informed real estate decisions through market insight, project evaluation, and strategic development guidance.',
                'sort_order' => 5,
            ],
            [
                'title' => 'Strategic Marketing & Business Development',
                'slug' => 'strategic-marketing-business-development',
                'short_description' => 'Brand positioning, expansion strategies, commercial planning, and business development support.',
                'full_description' => 'We help brands and organizations strengthen their market position, expand strategically, and build sustainable growth pathways through tailored marketing and business development solutions.',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], $service + ['is_published' => true]);
        }

        $projects = [
            [
                'title' => 'Smart Residential Design Concept',
                'slug' => 'smart-residential-design-concept',
                'category' => 'Architectural Design',
                'client_name' => null,
                'country' => null,
                'short_description' => 'Modern residential architectural concept integrating efficient space planning, sustainability principles, and digital visualization.',
                'full_description' => 'Modern residential architectural concept integrating efficient space planning, sustainability principles, and digital visualization.',
            ],
            [
                'title' => 'AI Process Automation Advisory',
                'slug' => 'ai-process-automation-advisory',
                'category' => 'AI & Automation Projects',
                'client_name' => null,
                'country' => null,
                'short_description' => 'Consulting support for workflow automation and intelligent process optimization for operational efficiency.',
                'full_description' => 'Consulting support for workflow automation and intelligent process optimization for operational efficiency.',
            ],
            [
                'title' => 'Professional E-Learning Platform',
                'slug' => 'professional-elearning-platform',
                'category' => 'E-Learning Systems',
                'client_name' => null,
                'country' => null,
                'short_description' => 'Design and advisory for an online learning ecosystem supporting training delivery, certification, and remote learning management.',
                'full_description' => 'Design and advisory for an online learning ecosystem supporting training delivery, certification, and remote learning management.',
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], $project + ['is_published' => true, 'gallery_paths' => []]);
        }

        $posts = [
            [
                'title' => 'The Future of Architecture in the Age of Artificial Intelligence',
                'excerpt' => 'How AI and computational design are reshaping the way we design, deliver, and operate buildings.',
            ],
            [
                'title' => 'How Digital Transformation is Reshaping Modern Business',
                'excerpt' => 'A practical view of systems, automation, and data-driven operations for sustainable growth.',
            ],
            [
                'title' => 'Why Smart Buildings Matter for Sustainable Development',
                'excerpt' => 'Smart building strategies that improve performance, resilience, and long-term value.',
            ],
        ];

        foreach ($posts as $i => $post) {
            $title = $post['title'];
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'excerpt' => $post['excerpt'],
                    'content' => '<p>Coming soon.</p>',
                    'category_id' => $blogCategories[$i % $blogCategories->count()]?->id,
                    'author_id' => $admin->id,
                    'published_at' => now(),
                ]
            );
        }

        $testimonials = [
            'JC Architecture & AI Consulting Inc. brings a rare combination of technical depth, innovation, and strategic thinking. Their multidisciplinary approach adds real value to every engagement.',
            'Their expertise in architecture, digital transformation, and intelligent systems makes them a strong consulting partner for organizations seeking future-ready solutions.',
            'Professional, responsive, and highly knowledgeable, the team provides solutions that are both practical and visionary.',
        ];

        foreach ($testimonials as $i => $quote) {
            Testimonial::query()->updateOrCreate(
                ['quote' => $quote],
                ['sort_order' => $i + 1, 'is_published' => true]
            );
        }

        $faqs = [
            [
                'q' => 'What industries do you serve?',
                'a' => 'We serve businesses, institutions, real estate developers, educational organizations, startups, and public sector entities across multiple industries.',
            ],
            [
                'q' => 'Do you work internationally?',
                'a' => 'Yes. We provide services in Canada, Rwanda, and internationally depending on project scope and client needs.',
            ],
            [
                'q' => 'Can you support both technical and strategic projects?',
                'a' => 'Yes. Our strength lies in combining technical consulting with strategic advisory, allowing us to deliver integrated and results-oriented solutions.',
            ],
            [
                'q' => 'Do you offer custom training programs?',
                'a' => 'Yes. We design training programs tailored to organizational needs, technical goals, and learning outcomes.',
            ],
            [
                'q' => 'Can you help with digital transformation?',
                'a' => 'Yes. We provide digital transformation consulting, process improvement support, and technology integration solutions.',
            ],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::query()->updateOrCreate(
                ['question' => $faq['q']],
                ['answer' => $faq['a'], 'sort_order' => $i + 1, 'is_published' => true]
            );
        }

        Setting::query()->updateOrCreate(
            ['key' => 'company.profile', 'group' => 'company'],
            ['value' => [
                'name' => 'JC Architecture & AI Consulting Inc.',
                'tagline' => 'Smart Design. Intelligent Solutions. Lasting Impact.',
                'markets' => ['Canada', 'Rwanda', 'International'],
            ]]
        );

        Setting::query()->updateOrCreate(
            ['key' => 'seo.home', 'group' => 'seo'],
            ['value' => [
                'meta_title' => 'JC Architecture & AI Consulting Inc. | Architecture, AI, Digital Solutions & Strategic Consulting',
                'meta_description' => 'JC Architecture & AI Consulting Inc. provides expert services in architecture, construction consulting, artificial intelligence, digital transformation, e-learning, real estate advisory, and strategic marketing in Canada, Rwanda, and internationally.',
                'keywords' => [
                    'architecture consulting',
                    'AI consulting',
                    'digital transformation',
                    'BIM services',
                    'smart building consulting',
                    'e-learning solutions',
                    'real estate advisory',
                    'business development consulting',
                    'Canada consulting firm',
                    'Rwanda consulting firm',
                ],
            ]]
        );
    }
}
