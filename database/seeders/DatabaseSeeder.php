<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin2',
            'email' => 'admin2@blog.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'bio' => 'Platform administrator and editor.',
        ]);
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Platform administrator and editor.',
        ]);

        // Create Authors
        $authors = [];
        $authorData = [
            ['name' => 'Sarah Chen', 'username' => 'sarahchen', 'bio' => 'Writer, thinker, coffee enthusiast. Exploring ideas at the intersection of technology and humanity.'],
            ['name' => 'Marcus Johnson', 'username' => 'marcusj', 'bio' => 'Software engineer by day, storyteller by night. Writing about code, life, and everything in between.'],
            ['name' => 'Priya Sharma', 'username' => 'priyawrites', 'bio' => 'Designer and creative writer. Passionate about visual storytelling and user experience.'],
            ['name' => 'Alex Rivera', 'username' => 'alexr', 'bio' => 'Entrepreneur and tech writer. Building the future one article at a time.'],
            ['name' => 'Emma Wilson', 'username' => 'emmawilson', 'bio' => 'Journalist and independent thinker. Covering culture, science, and innovation.'],
        ];

        foreach ($authorData as $data) {
            $authors[] = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => Str::slug($data['username']) . '@blog.com',
                'password' => Hash::make('password'),
                'role' => 'author',
                'bio' => $data['bio'],
            ]);
        }

        // Create Categories
        $categories = [];
        $categoryNames = ['Technology', 'Design', 'Programming', 'Productivity', 'Science', 'Culture'];
        foreach ($categoryNames as $name) {
            $categories[] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // Create Posts
        $posts = [
            [
                'title' => 'The Future of Artificial Intelligence in Everyday Life',
                'excerpt' => 'AI is no longer a distant dream. It\'s woven into the fabric of our daily routines — from the moment we wake up to the second we fall asleep.',
                'body' => "Artificial intelligence has quietly become one of the most transformative technologies of the 21st century. We often think of AI as something futuristic — robots walking among us, self-driving cities, or sentient machines. But the truth is more subtle and, in many ways, more profound.\n\nEvery morning, millions of people wake up to an alarm set by a smart assistant that learned their sleep patterns. They check their phones, where AI has curated their news feed, filtered their emails, and even suggested what to wear based on the weather forecast.\n\nThe real revolution isn't in grand, cinematic breakthroughs. It's in the quiet automation of mundane tasks, the subtle personalization of experiences, and the invisible optimization of systems we rely on every day.\n\nConsider healthcare. AI algorithms can now detect certain cancers earlier than human radiologists. They can predict patient deterioration hours before it happens. They can identify drug interactions that would take a pharmacist hours to research.\n\nOr consider education. Adaptive learning platforms adjust their curriculum in real-time based on student performance. AI tutors provide personalized feedback at scale. Language learning apps use natural language processing to evaluate pronunciation with remarkable accuracy.\n\nThe question is no longer whether AI will transform our lives — it already has. The question is whether we'll shape that transformation wisely, with attention to equity, privacy, and human dignity.\n\nAs we stand at this crossroads, the choices we make today will echo for generations. The future of AI isn't just a technological challenge — it's a profoundly human one.",
                'category' => 0,
                'author' => 0,
                'featured' => true,
            ],
            [
                'title' => 'Minimalist Design: Less Really Is More',
                'excerpt' => 'In a world drowning in visual noise, the most powerful design choice might be restraint.',
                'body' => "Every great designer eventually arrives at the same conclusion: simplicity is the ultimate sophistication. But achieving true minimalism in design requires far more effort than it appears.\n\nMinimalist design isn't about removing things until nothing is left. It's about removing things until nothing more can be taken away without losing meaning. There's a crucial difference.\n\nConsider the evolution of Apple's product design under Jony Ive. Each generation stripped away another layer of unnecessary complexity, revealing the essential form beneath. The result wasn't emptiness — it was clarity.\n\nThe principles of minimalist design extend beyond aesthetics. They influence how users think, feel, and interact with products. A clean interface reduces cognitive load. Ample white space guides the eye naturally. Thoughtful typography conveys hierarchy without decorative elements.\n\nBut minimalism has its critics. Some argue it can feel cold, impersonal, or exclusionary. Others point out that what seems \"simple\" to a designer may be confusing to users who rely on visual cues and affordances.\n\nThe best minimalist design acknowledges these concerns. It uses restraint purposefully, ensuring that every remaining element earns its place. It balances beauty with usability, elegance with accessibility.\n\nIn the end, less truly is more — but only when \"less\" is the result of careful, intentional design thinking.",
                'category' => 1,
                'author' => 2,
                'featured' => false,
            ],
            [
                'title' => 'Why Every Developer Should Learn to Write',
                'excerpt' => 'The best code tells a story. The best developers know how to tell it in words too.',
                'body' => "There's a popular myth in the tech industry that developers don't need to be good writers. Code speaks for itself, the argument goes. But this couldn't be further from the truth.\n\nWriting is thinking made visible. When you write clearly about a technical concept, you're forced to understand it deeply. The gaps in your knowledge become painfully obvious when you try to explain something to someone else.\n\nConsider the best technical documentation you've ever read. It probably felt effortless — clear, concise, and logically structured. But behind that effortlessness was a writer who understood both the technology and their audience.\n\nGood writing skills make developers better at:\n\n- Writing clear commit messages\n- Creating useful documentation\n- Crafting thoughtful code reviews\n- Communicating with non-technical stakeholders\n- Writing persuasive technical proposals\n- Mentoring junior developers\n\nThe skills that make good writing also make good code: clarity, structure, audience awareness, and the ability to convey complex ideas simply.\n\nStart small. Write a blog post about something you learned this week. Document a project you're proud of. Explain a concept to a friend who isn't in tech.\n\nThe more you write, the better you'll code. And the better you code, the more you'll have to write about.",
                'category' => 2,
                'author' => 1,
                'featured' => false,
            ],
            [
                'title' => 'The Art of Deep Work in a Distracted World',
                'excerpt' => 'In an age of constant notifications, the ability to focus deeply has become a superpower.',
                'body' => "Cal Newport coined the term \"deep work\" to describe the ability to focus without distraction on a cognitively demanding task. In our hyper-connected world, this ability has become increasingly rare — and increasingly valuable.\n\nThink about your typical workday. How many hours do you spend in a state of genuine, undistracted focus? For most knowledge workers, the answer is shockingly low — often less than two hours.\n\nThe rest of the time is consumed by what Newport calls \"shallow work\": emails, meetings, Slack messages, context switching, and the constant pull of social media. These activities feel productive but rarely produce meaningful results.\n\nDeep work, by contrast, is where breakthroughs happen. It's where complex problems get solved, elegant code gets written, and creative insights emerge.\n\nHere are some strategies for cultivating deep work:\n\nTime blocking: Dedicate specific hours to deep work and guard them fiercely.\n\nEnvironment design: Create a physical space that signals \"focus\" to your brain.\n\nDigital minimalism: Eliminate unnecessary notifications and apps.\n\nRituals: Develop pre-work routines that help you transition into a focused state.\n\nThe ability to perform deep work isn't just a productivity hack. It's a fundamental skill that separates good work from great work. And in a world where everyone is distracted, it might be your greatest competitive advantage.",
                'category' => 3,
                'author' => 3,
                'featured' => false,
            ],
            [
                'title' => 'Understanding Quantum Computing: A Beginner\'s Guide',
                'excerpt' => 'Quantum computers aren\'t just faster classical computers — they\'re an entirely different way of processing information.',
                'body' => "Quantum computing is one of those topics that sounds intimidating but is actually quite beautiful once you grasp the basics. Let's break it down.\n\nClassical computers — the devices you're reading this on — process information in bits. Each bit is either a 0 or a 1. Everything your computer does, from displaying this text to streaming video, is built on this simple binary foundation.\n\nQuantum computers use quantum bits, or qubits. Unlike classical bits, qubits can exist in a state called superposition, where they are both 0 and 1 simultaneously. This isn't just a theoretical curiosity — it's a fundamental property of quantum mechanics that enables entirely new kinds of computation.\n\nWhen qubits are entangled — another quantum phenomenon — measuring one instantly reveals information about the other, regardless of the distance between them. This creates computational possibilities that have no classical equivalent.\n\nBut here's the important nuance: quantum computers aren't universally faster than classical computers. They're dramatically better at specific types of problems:\n\nCryptography and code breaking\nDrug discovery and molecular simulation\nOptimization problems\nMachine learning\nFinancial modeling\n\nFor everyday tasks like browsing the web or writing documents, classical computers will remain superior. Quantum advantage emerges only when the problem structure aligns with quantum mechanics.\n\nWe're still in the early days. Current quantum computers are noisy, error-prone, and require extreme cooling. But progress is accelerating, and the implications for science, medicine, and technology are profound.",
                'category' => 4,
                'author' => 4,
                'featured' => false,
            ],
            [
                'title' => 'The Renaissance of Indie Publishing',
                'excerpt' => 'How independent creators are reshaping the publishing landscape, one newsletter at a time.',
                'body' => "Something remarkable is happening in the world of publishing. After decades of consolidation, where a handful of major publishers controlled what got published and how, independent creators are reclaiming the power to share their ideas directly with audiences.\n\nPlatforms like Substack, Ghost, and Medium have democratized publishing. Anyone with something valuable to say can build an audience and sustain themselves through their writing. No gatekeepers required.\n\nBut this isn't just about technology. It's about a fundamental shift in how people consume information. Readers are moving away from algorithmically curated feeds toward curated, personal voices they trust.\n\nThe numbers tell the story. Top independent writers earn millions annually. Niche newsletters with just a few thousand subscribers sustain their creators comfortably. The long tail of content creation has become viable.\n\nWhat makes indie publishing work?\n\nDirect relationship with readers: No algorithm sits between creator and audience.\n\nTrust and authenticity: Independent voices often feel more genuine than corporate publications.\n\nSpecialization: Niche expertise finds its audience more easily than ever.\n\nSustainability: Subscription models provide predictable revenue.\n\nOf course, challenges remain. Discovery is harder without platform algorithms. The pressure to publish consistently can lead to burnout. And the market is increasingly crowded.\n\nBut the trend is clear: the future of publishing is personal, independent, and direct. The printing press democratized reading. The internet is democratizing writing.",
                'category' => 5,
                'author' => 0,
                'featured' => false,
            ],
            [
                'title' => 'Building Resilient Systems: Lessons from Chaos Engineering',
                'excerpt' => 'The best way to build reliable systems is to deliberately break them.',
                'body' => "In 2010, Netflix did something that seemed counterintuitive: they created a tool called Chaos Monkey that randomly terminated servers in their production environment during business hours. The reasoning was simple but profound — if you want to build resilient systems, you need to test that resilience constantly.\n\nThis approach, now known as chaos engineering, has become a cornerstone of modern software reliability. The principle is straightforward: inject controlled failures into your system to discover weaknesses before they cause real outages.\n\nBut chaos engineering is more than just breaking things. It's a disciplined practice built on scientific methodology:\n\nDefine a steady state: What does \"normal\" look like for your system?\n\nForm a hypothesis: What should happen when a specific failure occurs?\n\nIntroduce the failure: Deliberately cause the condition you're testing.\n\nObserve the results: Did the system behave as expected?\n\nLearn and improve: Fix any unexpected behaviors you discover.\n\nThe lessons from chaos engineering extend beyond software. Any complex system — organizations, supply chains, even personal habits — benefits from deliberate stress testing.\n\nThe companies that embrace this philosophy don't just build better software. They build a culture of resilience, where failure is expected, planned for, and learned from. In a world of increasing complexity, that culture might be the most valuable thing you can build.",
                'category' => 2,
                'author' => 1,
                'featured' => false,
            ],
            [
                'title' => 'The Psychology of Color in Digital Interfaces',
                'excerpt' => 'Colors don\'t just make interfaces pretty — they shape how users think, feel, and act.',
                'body' => "Color is one of the most powerful tools in a designer's arsenal, yet it's often treated as an afterthought. The truth is, color choices in digital interfaces can dramatically influence user behavior, emotional response, and overall experience.\n\nConsider the color blue. It's the most popular color in digital design, used by Facebook, Twitter, LinkedIn, and countless other platforms. This isn't coincidence — blue is associated with trust, stability, and professionalism. It also happens to be the color that's easiest on the eyes for extended screen time.\n\nRed, on the other hand, creates urgency. It's why sale badges are red, why error messages use red, and why notification badges are those insistent little red circles. Red activates our fight-or-flight response, making us more likely to take immediate action.\n\nGreen signals safety and progress. It's the universal color of \"go\" — used for success messages, confirmation buttons, and positive status indicators.\n\nBut color psychology isn't universal. Cultural context matters enormously. White symbolizes purity and cleanliness in Western cultures but represents mourning in many Asian cultures. Red means danger in the West but good fortune in China.\n\nFor designers, this means color choices should be informed by audience research, not personal preference. The best interfaces use color purposefully — to guide attention, convey meaning, and create emotional resonance that aligns with the product's goals.",
                'category' => 1,
                'author' => 2,
                'featured' => false,
            ],
        ];

        $allUsers = array_merge([$admin], $authors);

        foreach ($posts as $postData) {
            $post = Post::create([
                'user_id' => $allUsers[$postData['author']]->id,
                'category_id' => $categories[$postData['category']]->id,
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']) . '-' . Str::random(6),
                'excerpt' => $postData['excerpt'],
                'body' => $postData['body'],
                'is_published' => true,
                'is_featured' => $postData['featured'],
                'published_at' => now()->subDays(rand(1, 30)),
            ]);

            // Add random likes
            $likers = collect($allUsers)->shuffle()->take(rand(1, 5));
            foreach ($likers as $liker) {
                Like::create([
                    'user_id' => $liker->id,
                    'post_id' => $post->id,
                ]);
            }

            // Add random comments
            $commentTexts = [
                'This is a fantastic article! Really opened my eyes to new perspectives.',
                'Great read. I\'ve been thinking about this topic for a while.',
                'Well written. Would love to see a follow-up on this.',
                'Interesting take. I\'d push back a bit on the third point though.',
                'Bookmarked this for future reference. Thanks for sharing.',
                'This resonated with me deeply. Sharing with my team.',
            ];

            $commentCount = rand(0, 3);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'user_id' => $allUsers[array_rand($allUsers)]->id,
                    'post_id' => $post->id,
                    'body' => $commentTexts[array_rand($commentTexts)],
                ]);
            }
        }
    }
}
