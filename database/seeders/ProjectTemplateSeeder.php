<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            ['id' => '1', 'category' => '1', 'name' => 'blog ideas', 'description' => 'Get ideas for your blog in minutes - all we need is your brand name and description.', 'metadata' => '{
                "field_1": {
                    "type": "input",
                    "title": "Brand Name",
                    "description": "Generate blog ideas for a brand known as",
                    "placeholder": "e.g. write.ai"
                },
                "field_2": {
                    "type": "textarea",
                    "title": "Describe your product",
                    "description": "The product/brand is",
                    "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '2', 'category' => '1', 'name' => 'blog intro', 'description' => 'Jump into a whole first draft of your blog intro in minutes — all we need is your title and topic.', 'metadata' => '{
                "field_1": {
                    "type": "input",
                    "title": "What is your blog title?",
                    "description": "Write an intro paragraph for a blog titled",
                    "placeholder": "e.g. 5 reasons why working with ai is the future"
                },
                "field_2": {
                    "type": "textarea",
                    "title": "What is the blog about?",
                    "description": "The main objective of the blog is",
                    "placeholder": "e.g. a blog about how ai is expected to change how people work"
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '3', 'category' => '1', 'name' => 'blog outline', 'description' => 'Get an outline of your blog post in minutes — all we need is your title and topic.', 'metadata' => '{
                "field_1": {
                    "type": "input",
                    "title": "What is your blog title?",
                    "description": "Write a blog title and outline about",
                    "placeholder": "e.g. 5 reasons why working with ai is the future"
                },
                "field_2": {
                    "type": "textarea",
                    "title": "What is the blog about?",
                    "description": "The entire blog is about",
                    "placeholder": "e.g. 5 reasons why working with ai is the future"
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '4', 'category' => '1', 'name' => 'blog title', 'description' => 'Generate blog titles for your blog in minutes — all we need is a description of your niche(s).', 'metadata' => '{
                "field_1": {
                    "type": "textarea",
                    "title": "What niche(s) are you in?",
                    "description": "Generate blog titles in the following niche(s)",
                    "placeholder": "e.g. ai writing, sports, dog food"
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '5', 'category' => '1', 'name' => 'keyword generator', 'description' => 'Generate keywords for your blog in minutes — all we need is a description of your niche(s).', 'metadata' => '{
                "field_1": {
                    "type": "textarea",
                    "title": "What niche(s) are you in?",
                    "description": "Generate keywords in the following niche(s)",
                    "placeholder": "e.g. ai writing, sports, dog food"
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '6', 'category' => '1', 'name' => 'product descriptions', 'description' => 'Generate product descriptions for your blog in minutes — all we need is your description.', 'metadata' => '{
                "field_1": {
                    "type": "input",
                    "title": "What is your product called?",
                    "description": "Generate product descriptions for a product known as",
                    "placeholder": "e.g. Product X"
                },
                "field_2": {
                    "type": "textarea",
                    "title": "Describe your product",
                    "description": "The product is",
                    "placeholder": "e.g a a smartphone charging solution that can charge your smartphone in just 30 minutes."
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '7', 'category' => '1', 'name' => 'blog section', 'description' => 'Generate a section of your blog in minutes — all we need is your title and topic.', 'metadata' => '{
                "field_1": {
                    "type": "input",
                    "title": "blog topic",
                    "description": "Write a blog paragraph about",
                    "placeholder": "e.g. 5 reasons why working with ai is the future"
                },
                "field_2": {
                    "type": "textarea",
                    "title": "what is the main point of the paragraph",
                    "description": "The main point of the paragraph is to",
                    "placeholder": "e.g. Introduce ai, what it means, when the idea was conceptualized and how it works."
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => '8', 'category' => '0', 'name' => 'freestyle', 'description' => 'Prompt the AI to write about anything - all we need is a description of what you want.', 'metadata' => '{
                "field_1": {
                    "type": "input",
                    "title": "What do you want to create?",
                    "description": "Create a",
                    "placeholder": "e.g. a cover letter for an employment opportunity"
                },
                "field_2": {
                    "type": "textarea",
                    "title": "Which points do you want to be covered?",
                    "description": "Cover the following points:",
                    "placeholder": "e.g. Create an outline first"
                }
            }', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            [
                'category' => '1', 
                'name' => 'landing page', 
                'description' => 'The main copy that drives traffic to your page and helps you convert leads.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Site/Brand Name",
                        "description": "Generate sales landing page content for a site known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe your brand, target audience, features and benefits",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs. Its main target audience are small business owners, entrepreneurs and social media managers. etc."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'Website headlines and slogans', 
                'description' => 'Generate headlines and slogans that convert traffic to customers.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a short website headline on one line and a slogan on the other line and separate the lines with a line break tag i.e <br> and put a full stop at the end of each sentence. The site/brand is known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe your brand",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'Meta titles and descriptions', 
                'description' => 'Generate SEO meta titles and descriptions.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Describe product or service",
                        "description": "Generate SEO meta title and description. Make sure that you separate and indicate the line that is a meta title and the line that is a meta description at the beginning of the line. The site/brand is known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The main keywords for this product/brand are",
                        "placeholder": "e.g ai, copywriting, article writing etc."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Facebook Ads', 
                'description' => 'Generate compelling Facebook ads that converts traffic.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a facebook ad copy for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Google Ads', 
                'description' => 'Generate compelling google ads that converts traffic.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a google ad copy for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Instagram Captions', 
                'description' => 'Generate compelling instagram captions that converts traffic.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate an instagram caption for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '3', 
                'name' => 'Email Copy', 
                'description' => 'Generate compelling instagram captions that converts traffic.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Describe the main purpose of the email",
                        "description": "Generate an email whose main purpose is to",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The keywords are",
                        "placeholder": "e.g ai, copywriter, content generator etc."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '3', 
                'name' => 'Press Release', 
                'description' => 'Generate compelling and newsworthy press releases for business.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a press release with 300-400 words whose main purpose is to",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe the services you offer and or the announcement",
                        "description": "The contents of the press release are",
                        "placeholder": "e.g we are an ai powered content generator for small businesses and entrepreneurs. From our data, 80% of businesses experienced exceptional business growth after utilizing our tool. We expect that product roll outs during the second quarter of our calendar will increase growth tremendously."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '3', 
                'name' => 'Launch Product', 
                'description' => 'Create buzz for your new product by generating engaging emails.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate an email to build anticipation for a product/service known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe the main points of the email",
                        "description": "The contents of the email are",
                        "placeholder": "e.g we are an ai powered content generator for small businesses and entrepreneurs. 80% of businesses experienced exceptional business growth after utilizing our tool."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '3', 
                'name' => 'Cold Emails', 
                'description' => 'Send out cold emails that capture your recipients\' attention.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Email Content",
                        "description": "Generate a cold email with the following points",
                        "placeholder": "Information about the recipient, goal of the email, description of your product etc."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '3', 
                'name' => 'Client Testimonials', 
                'description' => 'Generate and share client reviews about your product to convert more leads.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Email Content",
                        "description": "Generate a customer showcase email to send to prospective clients showing them the advantages of my product/service. Use the following points:",
                        "placeholder": "Introduce your product/service, indicate customer name, their background and how your product/service helped them in the 3rd person"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Twitter Captions', 
                'description' => 'Generate compelling twitter captions that converts traffic.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a twitter caption for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Social Media Bio', 
                'description' => 'Write a short bio for that captivates your audience.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "What are the main points you want to cover",
                        "description": "Generate a social media bio with the following points:",
                        "placeholder": "e.g. I work in the xyz field, love dogs and currently building @abc_corp"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Cover Letter', 
                'description' => 'Generate a cover letter for your ideal job.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "What are the main points you want to cover",
                        "description": "Generate a cover letter with the following points:",
                        "placeholder": "e.g. I have 5 years experience as a software developer in FAANG companies etc."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Rejection Letter', 
                'description' => 'Generate a polite rejection letter when turning down candidates.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "What are the main points you want to cover",
                        "description": "Generate a rejection letter with the following points:",
                        "placeholder": "e.g. - Candidate name: John Doe - applied position: junior software developer, - rejection reason: not the best fit."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Business proposal', 
                'description' => 'Generate a business proposal for prospecting clients.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "What are the main points you want to cover",
                        "description": "Generate a business proposal with the following points:",
                        "placeholder": "e.g. - Company name: ABC Corp - Our services: we offer software development service, - Goal of the proposal: To obtain business for revamping the client\'s website."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '3', 
                'name' => 'Newsletter', 
                'description' => 'Generate an email newsletter that keeps your clients and leads updated.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate an email newsletter for a product/service known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe the main points of the newsletter",
                        "description": "The contents of the newsletter are",
                        "placeholder": "e.g - We are unveiling version 2.0. - We\'ve hit the 500 customer milestone. - What\'s next for ai?"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Job Description', 
                'description' => 'Find the words to put on the job description for your next hire.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "What are the main points you want to cover",
                        "description": "Generate a job description with the following points:",
                        "placeholder": "e.g. - Company name: ABC Corp - Role: junior software developer, - Ideal candidate: Willing to learn, experience in React, node JS and laravel frameworks, works greatly in a team"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'LinkedIn Post', 
                'description' => 'Generate compelling posts that engage your audience.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a linkedIn post for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Twitter Thread', 
                'description' => 'Generate engaging threads that resonate with your audience.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "What are the main points you want to cover",
                        "description": "Generate a twitter thread with the following points:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Content Calendar', 
                'description' => 'Generate a content calendar for a brand or service.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate a well formatted content calendar for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The product/brand is",
                        "placeholder": "e.g a copywriter powered by ai that assists small business owners and entrepreneurs."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'Article generator', 
                'description' => 'Generate an engaging article that relates to your audience.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Title",
                        "description": "Generate an article whose title is:",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "What is the article about?",
                        "description": "The article is about:",
                        "placeholder": "e.g Top 5 business destinations in Africa and the cost of living in these cities."
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Internal Memo', 
                'description' => 'Generate an internal memo to a specific department or team.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Department/Team Addressed",
                        "description": "Generate an internal memo addressed to the following department or team: ",
                        "placeholder": "e.g. Sales and marketing team"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe the content of the memo",
                        "description": "The memo contains the following information:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Product Brochure', 
                'description' => 'Generate a product brochure for your product or services.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand/Product",
                        "description": "Generate an product brochure for a brand or product known as: ",
                        "placeholder": "e.g. xyz product"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe the features of the product or service",
                        "description": "The product/service contains the following features:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '4', 
                'name' => 'Survey Questionnaire', 
                'description' => 'Generate a questionnaire for your business.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Survey Objective",
                        "description": "Generate a survey questionnaire with the following objective: ",
                        "placeholder": ""
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Describe the content of the survey",
                        "description": "The survey should contain the following information:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'Instagram Hashtags', 
                'description' => 'Generate engaging instagram hashtags.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate instagram hashtags for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The hashtags should cover the following areas:",
                        "placeholder": "e.g ai writing, copywriting, ai"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '2', 
                'name' => 'YouTube Tags', 
                'description' => 'Generate engaging youtube tags.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "Brand Name",
                        "description": "Generate engaging youtube tags for a site/brand known as",
                        "placeholder": "e.g. write.ai"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "Keywords",
                        "description": "The youtube tags should cover the following areas:",
                        "placeholder": "e.g ai writing, copywriting, ai"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'Grammar Checker', 
                'description' => 'Check the grammar of your content easily.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Paste your content here",
                        "description": "Check the grammer of this content and correct it if necessary:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'blog conclusion', 
                'description' => 'Generate the conclusion for your blog post — all we need is your title and topic.', 
                'metadata' => '{
                    "field_1": {
                        "type": "input",
                        "title": "What is your blog title?",
                        "description": "Write the conclusion paragraph for a blog titled",
                        "placeholder": "e.g. 5 reasons why working with ai is the future"
                    },
                    "field_2": {
                        "type": "textarea",
                        "title": "What is the blog about?",
                        "description": "The main objective of the blog is",
                        "placeholder": "e.g. a blog about how ai is expected to change how people work"
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'Content Rewrite', 
                'description' => 'Rewrite your content conveniently - Just paste you existing content.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Paste your content here",
                        "description": "Rewrite this content:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'Content Summary', 
                'description' => 'Summarize your content conveniently - Just paste you existing content.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Paste your content here",
                        "description": "Summarize this content:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
            [
                'category' => '1', 
                'name' => 'FAQ Generator', 
                'description' => 'Generate relevant FAQs and their answers for your product/service.', 
                'metadata' => '{
                    "field_1": {
                        "type": "textarea",
                        "title": "Provide info about your product and service",
                        "description": "Generate FAQs for this product and services based on this information:",
                        "placeholder": ""
                    }
                }', 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($templates as $template) {
            DB::table('project_templates')->insert($template);
        }
    }
}
