<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\BoardMember;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                // IMPORTANT: always store bcrypt-hashed passwords
                'password' => Hash::make('admin12345'),
            ]
        );

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

        // Services mirror the static frontend portfolio (Departments 1–7).
        $services = [
            [
                'title' => 'Architecture & Construction Consulting',
                'slug' => 'architecture-construction',
                'title_fr' => 'Conseil en architecture & construction',
                'short_description' => 'Planning & design, BIM & digital twin, construction consulting, sustainable & smart buildings, and end-to-end residential renovation (Canada & Rwanda).',
                'short_description_fr' => 'Conception, BIM & jumeau numérique, conseil en construction, bâtiments durables et intelligents, et rénovation résidentielle clé en main.',
                'full_description' => 'Planning, design, construction consulting, sustainable and smart solutions, and full residential renovation services—for new builds and transformations across residential and commercial markets.',
                'full_description_fr' => 'Conseil architectural et construction de bout en bout.',
                'sections' => [
                    ['title' => 'Planning & Design', 'body' => "Architectural concept design (residential, commercial, mixed-use)\nSpace planning & layout optimization\n2D drafting (AutoCAD)\n3D modeling & visualization (Revit, SketchUp, Lumion, Archicad)\nBIM modeling & coordination\nDigital twin development\nPermit-ready documentation (Rwanda)"],
                    ['title' => 'Construction & Project Consulting', 'body' => "Construction planning & scheduling\nCost estimation & quantity takeoff\nTender documentation & contractor selection\nSite supervision & quality control\nRisk management & compliance"],
                    ['title' => 'Sustainable & Smart Building Solutions', 'body' => "Energy-efficient design\nGreen building consulting\nSmart home & IoT integration\nRenewable energy systems (solar, water reuse)\nClimate-responsive architecture"],
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'Artificial Intelligence & Innovation',
                'slug' => 'artificial-intelligence-innovation',
                'title_fr' => 'Intelligence artificielle & innovation',
                'short_description' => 'AI strategy & transformation, chatbots & ML, predictive analytics, MVP/SaaS product delivery, and innovation labs.',
                'short_description_fr' => 'Stratégie IA, chatbots & ML, analytics prédictive, produits MVP/SaaS et labs d’innovation.',
                'full_description' => 'Strategy, integration, and product innovation—from AI roadmaps and automation to chatbots, ML, and venture-style product delivery.',
                'full_description_fr' => 'Stratégie IA appliquée, automatisation et programmes d’innovation.',
                'sections' => [
                    ['title' => 'AI Strategy & Transformation', 'body' => "AI strategy development\nDigital transformation roadmaps\nProcess automation\nInnovation consulting"],
                    ['title' => 'AI Solutions & Integration', 'body' => "AI chatbot development\nMachine learning models\nPredictive analytics systems\nAI-driven decision support tools"],
                    ['title' => 'Innovation & Product Development', 'body' => "MVP development\nSaaS platform creation\nAI product design\nInnovation labs & startup incubation"],
                ],
                'sort_order' => 2,
            ],
            [
                'title' => 'Digital Services & Technology Solutions',
                'slug' => 'digital-services',
                'title_fr' => 'Services numériques & solutions technologiques',
                'short_description' => 'Web & e‑commerce, mobile apps, business systems, cloud (AWS/Azure), cybersecurity, and system integration.',
                'short_description_fr' => 'Web & e‑commerce, applications mobiles, systèmes métiers, cloud, cybersécurité et intégration.',
                'full_description' => 'Web and mobile delivery, business systems, cloud, security, and integrations—built for reliability and scale.',
                'full_description_fr' => 'Livraison produit et plateforme couvrant le web, les intégrations et les systèmes d’entreprise.',
                'sections' => [
                    ['title' => 'Web & Platform Development', 'body' => "Website design & development\nE-commerce platforms\nWeb applications\nUX/UI design"],
                    ['title' => 'Mobile & Software Solutions', 'body' => "Mobile app development (Android / iOS)\nBusiness management systems\nFintech applications\nCustom software solutions"],
                    ['title' => 'Infrastructure & Security', 'body' => "Cloud computing (AWS, Azure)\nData storage & backup\nCybersecurity solutions\nSystem integration"],
                ],
                'sort_order' => 3,
            ],
            [
                'title' => 'Professional Training & E-Learning',
                'slug' => 'training-elearning',
                'title_fr' => 'Formation professionnelle & e-learning',
                'short_description' => 'Corporate workshops, engineering-software training, LMS & online programmes, and certifications (AI, architecture, business).',
                'short_description_fr' => 'Ateliers entreprise, formation logiciels d’ingénierie, LMS & programmes en ligne, certifications.',
                'full_description' => 'Corporate programmes, digital skills, LMS setup, and certification tracks aligned to architecture, AI, business, and engineering software.',
                'full_description_fr' => 'Renforcement des capacités via cohortes, parcours de certification et écosystèmes d’apprentissage.',
                'sections' => [
                    ['title' => 'Training Programs', 'body' => "Professional training programs (AI, architecture, business)\nCorporate training workshops\nDigital skills development\nTraining on engineering design software tailored to client needs"],
                    ['title' => 'E-Learning & Distance Education', 'body' => "Online course creation\nVideo-based training programs\nLMS setup\nOnline education platforms"],
                    ['title' => 'Certification Programs', 'body' => "AI certification programs\nArchitecture & construction certification\nBusiness & entrepreneurship certification\nDigital badges & credentials"],
                ],
                'sort_order' => 4,
            ],
            [
                'title' => 'Real Estate Consulting & Investment Advisory',
                'slug' => 'real-estate-consulting',
                'title_fr' => 'Conseil immobilier & investissement',
                'short_description' => 'Feasibility & market analysis, financial modeling, property advisory, investment strategy—including cross-border consulting.',
                'short_description_fr' => 'Faisabilité & marché, modélisation financière, conseil immobilier, stratégie d’investissement transfrontalière.',
                'full_description' => 'Feasibility, market and financial analysis, property advisory, and investment strategy—including cross-border perspectives.',
                'full_description_fr' => 'Cadrage digne d’un investisseur — de la faisabilité à la valorisation et au positionnement stratégique.',
                'sections' => [
                    ['title' => 'Feasibility & Analysis', 'body' => "Feasibility studies\nMarket analysis & demand forecasting\nFinancial modeling (ROI, IRR, cash flow)"],
                    ['title' => 'Property Consulting', 'body' => "Property evaluation & advisory\nLand acquisition consulting\nBest-use analysis\nDue diligence"],
                    ['title' => 'Investment Advisory', 'body' => "Investment strategy development\nPortfolio planning\nReal estate development advisory\nCross-border investment consulting"],
                ],
                'sort_order' => 5,
            ],
            [
                'title' => 'Strategic Marketing & Business Development',
                'slug' => 'strategic-marketing-business-development',
                'title_fr' => 'Marketing stratégique & développement commercial',
                'short_description' => 'Market research & brand positioning, digital strategy, partnerships, expansion (Canada ↔ Africa), CRM & revenue growth.',
                'short_description_fr' => 'Étude de marché & marque, stratégie numérique, partenariats, expansion Canada–Afrique, CRM & croissance.',
                'full_description' => 'Research-led positioning, digital strategy, partnerships, expansion planning, and revenue optimization.',
                'full_description_fr' => 'Conseil go-to-market et croissance — marque, planification commerciale et développement structuré.',
                'sections' => [
                    ['title' => 'Marketing Strategy', 'body' => "Market research & analysis\nBrand positioning & identity\nDigital marketing strategy\nLead generation systems"],
                    ['title' => 'Business Development', 'body' => "Partnership strategy\nExpansion planning (Canada ↔ Africa)\nB2B networking\nCommercial strategy"],
                    ['title' => 'Sales & Growth Optimization', 'body' => "Sales funnel design\nCRM implementation\nCustomer acquisition strategy\nRevenue optimization"],
                ],
                'sort_order' => 6,
            ],
            [
                'title' => 'Water Management & Urban Sanitation',
                'slug' => 'water-management-department',
                'title_fr' => 'Gestion de l’eau & assainissement urbain',
                'short_description' => 'Integrated water supply, sanitation, environmental safeguards, smart systems, training, and asset management—Africa & Canada.',
                'short_description_fr' => 'Offre intégrée en alimentation en eau, assainissement, sauvegardes environnementales, systèmes intelligents et gestion d’actifs.',
                'full_description' => 'A dedicated department for integrated water management and urban sanitation. The full portfolio is presented on the department detail page.',
                'full_description_fr' => 'Département dédié à la gestion de l’eau et à l’assainissement urbain.',
                'sort_order' => 7,
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

        // Seed at least one board member and partner so the admin lists are non-empty.
        BoardMember::query()->updateOrCreate(
            ['email' => 'info@example.com'],
            [
                'name' => 'Board Member (Sample)',
                'name_fr' => 'Membre du conseil (Exemple)',
                'role' => 'Advisor',
                'role_fr' => 'Conseiller',
                'bio' => 'Sample profile seeded to validate the admin workflow. Replace with your real board information.',
                'bio_fr' => 'Profil exemple pour valider le workflow admin. Remplacez par vos informations réelles.',
                'phone' => null,
                'linkedin_url' => null,
                'image_path' => null,
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        Partner::query()->updateOrCreate(
            ['name' => 'Partner (Sample)'],
            [
                'name_fr' => 'Partenaire (Exemple)',
                'tagline' => 'Sample partner seeded for admin validation.',
                'tagline_fr' => 'Partenaire exemple pour valider l’admin.',
                'website_url' => null,
                'logo_path' => null,
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

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
