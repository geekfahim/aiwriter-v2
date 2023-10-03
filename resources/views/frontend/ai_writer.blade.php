@extends('frontend.layout')
@section('content')
    <header id="header-text-text" class="pt-75 pb-75 pt-lg-250 pb-lg-250 text-center dark">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg text-lg-right" style="">
                    <h2 style="" class="text-right" data-aos-easing="ease-in" data-aos-duration="2" data-aos="fade-up">
                        <strong class="">You Have a Vision; We Have AI writer</strong></h2>
                </div>
                <hr class="sep-vertical-x2-lg ml-30 mr-30">
                <div class="col-lg text-lg-left" style="">
                    <p class="text-secondary lead" style="color: rgb(220, 32, 215);" data-aos-easing="ease-in"
                       data-aos-duration="4" data-aos-once="true" data-aos="fade-up"><strong class="">A powerful AI
                            feature within the Prompt Engineer App that empowers you to create high-quality, engaging
                            content with ease combined with best prompts you can find.</strong></p>
                </div>
                <div class="col-12" style="">
                    <a href="{{url('signup')}}" class="btn btn-outline-light btn-lg mt-50 mt-lg-150 fx-btn-blick" style=""
                       data-aos="fade-right" data-aos-easing="ease-in" data-aos-duration="6">Get Started Today</a>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </header>
    <section id="benefits-3col-11" class="dark">
        <div class="container-fluid">
            <div class="row no-gutters">
                <div class="col-lg">
                    <div class="content-box d-sm-flex padding-x4" data-aos="slide-up" data-aos-easing="ease-in"
                         data-aos-duration="2" data-aos-once="true">
                        <div class="mr-sm-30">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                                 viewBox="0 0 64 64" width="48px" class="mb-20 icon svg-default">
                                <path d="m5.383 33.022c-.243.949-.383 1.945-.383 2.978 0 5.794 4.206 10 10 10v-2c-4.71 0-8-3.29-8-8 0-4.962 3.589-9 8-9h2.829l.153-.815c1.546-8.22 9.123-14.185 18.018-14.185 10.477 0 19 7.626 19 17v1h1c3.536 0 6 4.216 6 8 0 3.645-2.355 6-6 6v2c4.71 0 8-3.29 8-8 0-4.493-2.783-9.282-7.024-9.927-.537-10.048-9.74-18.073-20.976-18.073-4.097 0-7.938 1.156-11.156 3.157-2.647-3.251-6.59-5.157-10.844-5.157-7.72 0-14 6.28-14 14 0 2.682.761 5.288 2.201 7.538.85 1.327 1.939 2.509 3.182 3.484zm8.617-23.022c3.591 0 6.929 1.581 9.197 4.291-3.457 2.653-5.989 6.375-7.008 10.709h-1.189c-3.88 0-7.242 2.448-8.9 6.009-.849-.747-1.606-1.601-2.214-2.549-1.234-1.927-1.886-4.161-1.886-6.46 0-6.617 5.383-12 12-12z"></path>
                                <path d="m17 44h37v2h-37z"></path>
                                <path d="m17 50h37v2h-37z"></path>
                                <path d="m17 56h37v2h-37z"></path>
                            </svg>
                        </div>
                        <div class="" style="">
                            <h4 class="mb-20" style=""><strong class="">5000 + Free Ai prompts</strong></h4>
                            <p class="mb-0 text-secondary" style="color: rgb(255, 255, 255);">Explore over 5000 Free
                                prompts for ChatGPT&nbsp;</p>
                        </div>
                    </div>
                </div>
                <hr class="sep-vertical-lg ml-auto mr-auto">
                <div class="col-lg">
                    <div class="content-box d-sm-flex padding-x4" data-aos="slide-up" data-aos-easing="ease-in"
                         data-aos-duration="2" data-aos-once="true">
                        <div class="mr-sm-30">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                                 viewBox="0 0 64 64" width="48px" class="mb-20 icon svg-default">
                                <path d="m54 0h-44v21.142l-10 4.193v38.665h64v-38.665l-10-4.193zm-2 2v29.716l-20 12.537-20-12.537v-29.716zm-42 28.462-6.835-4.285 6.835-2.866zm-8 31.538v-34.193l30 18.807 30-18.807v34.193zm58.835-35.823-6.835 4.285v-7.151z"></path>
                                <path d="m31.529 31.882.471.251.471-.251c.429-.229 10.529-5.698 10.529-12.882 0-3.42-2.579-6-6-6-2.085 0-3.924 1.068-5 2.687-1.076-1.619-2.915-2.687-5-2.687-3.421 0-6 2.58-6 6 0 7.184 10.1 12.653 10.529 12.882zm-4.529-16.882c2.206 0 4 1.794 4 4h2c0-2.206 1.794-4 4-4 2.317 0 4 1.682 4 4 0 5.203-7.086 9.724-9 10.85-1.914-1.126-9-5.647-9-10.85 0-2.318 1.683-4 4-4z"></path>
                            </svg>
                        </div>
                        <div class="" style="">
                            <h4 class="mb-20" style=""><strong class="">All tools in one plan</strong></h4>
                            <p class="mb-0 text-secondary"
                               style="border-color: rgba(0, 0, 0, 0); color: rgb(255, 255, 255);">Save over 100$ monthly
                                with all tools and latest AI prompts&nbsp;in one workspace</p>
                        </div>
                    </div>
                </div>
                <hr class="sep-vertical-lg ml-auto mr-auto">
                <div class="col-lg">
                    <div class="content-box d-sm-flex padding-x4" data-aos="slide-up" data-aos-easing="ease-in"
                         data-aos-duration="2" data-aos-once="true">
                        <div class="mr-sm-30">
                            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                                 viewBox="0 0 64 64" width="48px" class="mb-20 icon svg-default">
                                <path d="m51 0c-7.168 0-13 5.832-13 13 0 2.702.83 5.213 2.246 7.294l-21.644 13.774c-1.978-1.895-4.653-3.068-7.602-3.068-6.065 0-11 4.935-11 11s4.935 11 11 11c4.134 0 7.739-2.295 9.618-5.676l18.397 7.359c-.002.106-.015.211-.015.317 0 4.963 4.037 9 9 9s9-4.037 9-9-4.037-9-9-9c-4.149 0-7.642 2.826-8.679 6.651l-17.899-7.159c.369-1.099.578-2.27.578-3.492 0-2.39-.774-4.598-2.074-6.403l21.587-13.737c2.375 2.54 5.744 4.14 9.487 4.14 7.168 0 13-5.832 13-13s-5.832-13-13-13zm-3 48c3.859 0 7 3.141 7 7s-3.141 7-7 7-7-3.141-7-7 3.141-7 7-7zm-37 3c-4.963 0-9-4.037-9-9s4.037-9 9-9 9 4.037 9 9-4.037 9-9 9zm40-27c-6.065 0-11-4.935-11-11s4.935-11 11-11 11 4.935 11 11-4.935 11-11 11z"></path>
                            </svg>
                        </div>
                        <div class="" style="">
                            <h4 class="mb-20" style=""><strong class="">Premium AI prompts</strong></h4>
                            <p class="mb-0 text-secondary"
                               style="border-color: rgba(0, 0, 0, 0); color: rgb(255, 255, 255);">Discover Premium
                                prompts for any niche created by industry experts to automate your task</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="desc-halfbg-text-3" class="pb-75 pt-md-150 pb-md-150 light">
        <div class="container">
            <div class="row">
                <div class="bg-box col-md-6 mb-50 mb-md-0 embed-responsive-4by3"
                     style="background: url(&quot;images//uploaded/2/write_AI.png&quot;);">
                </div>
                <div class="col-md-7 ml-auto" style="">
                    <h2 class="text-right" style="color: rgb(255, 255, 255);" data-aos="fade-left" data-aos-duration="3"
                        data-aos-once="true" data-aos-easing="ease-in"><strong class="">Transform Your&nbsp;<br>Writing
                            with AI</strong></h2>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 40 20" width="40"
                         class="mb-30 svg-default">
                        <path d="m0 8h40v4h-40z" fill-rule="evenodd"></path>
                    </svg>
                    <p class="mb-50 text-right" style="color: rgb(255, 255, 255);" data-aos="fade-left"
                       data-aos-easing="ease-in" data-aos-duration="4" data-aos-once="true"><strong class="">With the AI
                            Writer Tool, you can tap into the power of artificial intelligence&nbsp;<br>to generate
                            well-crafted, informative, and creative content.&nbsp;<br>Say goodbye to writer's block and
                            time-consuming research.</strong>
                    </p>
                    <p class="mb-50 text-center">
                        <a class="btn btn-outline-light fx-btn-blick"
                           href="{{url('signup')}}" style="color: rgb(255, 255, 255);"
                           data-aos="fade-left" data-aos-easing="ease-in"
                           data-aos-duration="5" data-aos-once="true"><strong>Create
                                Content Today</strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="action-text-btn" class="pt-50 pb-50 pt-lg-100 pb-lg-100 dark text-center">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-auto mw-100" style="">
                    <h2 class="" style="color: rgb(136, 33, 149);"><strong class="">Sign up for the AI
                            writer</strong><br></h2>
                </div>
                <div class="col-md-auto mw-100" style="">
                    <a href="{{url('signup')}}" class="btn btn-lg mb-30 mt-30 btn-outline-dark fx-btn-blick" style="">Sign Up</a>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="sep-bottom-9--2" class="section-sep sep-bottom pt-100 text-center light">
        <div class="container">
            <div class="row">
                <div class="col-12 ml-auto mr-auto">

                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="desc-text-halfbg-3" class="pt-75 pt-md-150 pb-md-150 light">
        <div class="container">
            <div class="row">
                <div class="col-md-7" style="">
                    <h2 style="color: rgb(255, 255, 255);" data-aos="fade-right" data-aos-duration="3"
                        data-aos-once="true" data-aos-easing="ease-in"><strong>Generate Content in Seconds</strong><br>
                    </h2>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 40 20" width="40"
                         class="mb-30 svg-secondary">
                        <path d="m0 8h40v4h-40z" fill-rule="evenodd"></path>
                    </svg>
                    <p class="mb-50" style="color: rgb(255, 255, 255);" data-aos="fade-right" data-aos-easing="ease-in"
                       data-aos-duration="4" data-aos-once="true"><strong>Harness the power of AI to generate
                            high-quality content in a matter of seconds.</strong><br><strong>Simply input your desired
                            topic, and our AI algorithms will analyze vast&nbsp;</strong><br><strong>amounts of data to
                            provide you with well-researched and relevant information.</strong></p>
                    <a class="btn btn-outline-light smooth fx-btn-blick" href="{{url('contact-us')}}#contact-center-form"
                       style="" target="_self" data-aos="fade-right" data-aos-easing="ease-in" data-aos-duration="5"
                       data-aos-once="true"><strong>Create Content</strong></a>
                </div>
                <div class="bg-box col-md-6 mt-50 mt-md-0 embed-responsive-4by3"
                     style="background-image: url(&quot;images//uploaded/2/AI_Prompt_Engineer.png&quot;); background-position: center center; background-size: cover;">
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="text-2col" class="pt-50 pt-md-100 pb-md-50 pt-lg-150 pb-lg-100 light full-height">
        <div class="container">
            <div class="row">
                <div class="col-md mb-50" style="">
                    <h4 class="text-primary" style="color: rgb(216, 43, 238);"><strong class="">Tailor-Made Content to
                            Match Your Style</strong></h4>
                    <h2 class="" style="color: rgb(136, 33, 149);"><strong class="">Customize and Fine-Tune</strong>
                    </h2>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 40 20" width="40"
                         class="mb-30 light svg-primary">
                        <path d="m0 8h40v4h-40z" fill-rule="evenodd" class=""></path>
                    </svg>
                    <p class="" style="color: rgb(0, 0, 0);">Personalize your content to match your unique writing style
                        and brand voice with best prompts created by us. The AI Writer Tool allows you to fine-tune the
                        generated content, making it align perfectly with your preferences. Add your personal touch,
                        make edits, and customize the output to ensure that it reflects your vision and resonates with
                        your target audience.</p>
                </div>
                <div class="col-md mb-50" style="">
                    <h4 class="text-primary" style="color: rgb(5, 127, 168);"><strong class="">Enhance Your Writing
                            Workflow</strong></h4>
                    <h2 class="" style="color: rgb(0, 192, 255);"><strong class="">Boost Your Productivity</strong></h2>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 40 20" width="40"
                         class="mb-30 svg-primary">
                        <path d="m0 8h40v4h-40z" fill-rule="evenodd"></path>
                    </svg>
                    <p class="" style="color: rgb(0, 0, 0); border-color: rgb(255, 255, 255);">The AI Writer Tool
                        streamlines your writing workflow and boosts your productivity. Save valuable time and effort by
                        automating parts of the content creation process. Focus on crafting compelling narratives,
                        polishing your ideas, and engaging with your readers, while the AI Writer Tool takes care of
                        generating the initial drafts and providing valuable insights.</p>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="sep-bottom-9" class="section-sep sep-bottom pt-100 text-center light">
        <div class="container">
            <div class="row">
                <div class="col-12 ml-auto mr-auto">

                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="price-5col" class="pt-75 pb-75 pt-lg-100 pb-lg-100 text-center light">
        <div class="container">
            <div class="row border-grid no-gutters">
                <div class="col-12" style="">
                    <h2 style="color: rgb(255, 255, 255);" data-aos="fade" data-aos-easing="ease-in"
                        data-aos-duration="2" data-aos-once="true"><strong class="">Choose Your Plan and Discover AI
                            Prompts</strong></h2>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 40 20" width="40"
                         class="mb-30 svg-secondary">
                        <path d="m0 8h40v4h-40z" fill-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="col-lg">
                    <div class="content-box bg-default border padding-x2" data-aos="fade" data-aos-easing="ease-in"
                         data-aos-duration="2" data-aos-once="true" style="">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                             viewBox="0 0 64 64" width="48px" class="mb-30 mt-10 icon svg-secondary">
                            <path d="m54 0h-44v21.142l-10 4.193v38.665h64v-38.665l-10-4.193zm-2 2v29.716l-20 12.537-20-12.537v-29.716zm-42 28.462-6.835-4.285 6.835-2.866zm-8 31.538v-34.193l30 18.807 30-18.807v34.193zm58.835-35.823-6.835 4.285v-7.151z"></path>
                        </svg>
                        <h4 class="">Plan 1</h4>
                        <h3 class="mb-20">FREE</h3>
                        <p class="mb-30 text-secondary" style="">Plan benifit 1<br>Plan benifit 2<br>Plan Benifit 3</p>
                        <a href="{{url('signup')}}" class="btn btn-outline-dark fx-btn-blick"><span>Try now</span></a>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="content-box bg-default border padding-x2" data-aos="fade" data-aos-easing="ease-in"
                         data-aos-duration="2.5" data-aos-once="true">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                             viewBox="0 0 64 64" width="48px" class="mb-30 mt-10 icon svg-secondary">
                            <path d="m30.707 28 13-13.146-1.414-1.488-12.293 12.257-6.293-6.311-1.414 1.551 7 7.137z"></path>
                            <path d="m54 0h-44v21.142l-10 4.193v38.665h64v-38.665l-10-4.193zm-2 2v29.716l-20 12.537-20-12.537v-29.716zm-42 28.462-6.835-4.285 6.835-2.866zm-8 31.538v-34.193l30 18.807 30-18.807v34.193zm58.835-35.823-6.835 4.285v-7.151z"></path>
                        </svg>
                        <h4 class="">Plan 2</h4>
                        <h3 class="mb-20"><strong>$9.99</strong><sup>
                                <del>$15.99</del>
                            </sup></h3>
                        <p class="mb-30 text-secondary">
                            In our work we try to use only the most convenient and interesting solutions.
                        </p>
                        <a href="{{url('signup')}}" class="btn btn-outline-dark fx-btn-blick"><span>Buy now</span></a>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="content-box bg-default border padding-x2" data-aos="fade" data-aos-easing="ease-in"
                         data-aos-duration="3" data-aos-once="true">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                             viewBox="0 0 64 64" width="48px" class="mb-30 mt-10 icon svg-secondary">
                            <path d="m54 0h-44v21.142l-10 4.193v38.665h64v-38.665l-10-4.193zm-2 2v29.716l-20 12.537-20-12.537v-29.716zm-42 28.462-6.835-4.285 6.835-2.866zm-8 31.538v-34.193l30 18.807 30-18.807v34.193zm58.835-35.823-6.835 4.285v-7.151z"></path>
                            <path d="m31.529 31.882.471.251.471-.251c.429-.229 10.529-5.698 10.529-12.882 0-3.42-2.579-6-6-6-2.085 0-3.924 1.068-5 2.687-1.076-1.619-2.915-2.687-5-2.687-3.421 0-6 2.58-6 6 0 7.184 10.1 12.653 10.529 12.882zm-4.529-16.882c2.206 0 4 1.794 4 4h2c0-2.206 1.794-4 4-4 2.317 0 4 1.682 4 4 0 5.203-7.086 9.724-9 10.85-1.914-1.126-9-5.647-9-10.85 0-2.318 1.683-4 4-4z"></path>
                        </svg>
                        <h4 class="">Plan 3</h4>
                        <h3 class="mb-20"><strong>$19.99</strong></h3>
                        <p class="mb-30 text-secondary">
                            In our work we try to use only the most convenient and interesting solutions.
                        </p>
                        <a href="{{url('signup')}}" class="btn btn-outline-dark fx-btn-blick"><span>Buy now</span></a>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="content-box bg-default border padding-x2" data-aos-easing="ease-in" data-aos="fade"
                         data-aos-duration="3.5" data-aos-once="true">
                        <img class="position-absolute r-0 t-0" src="images/stamp-1-primary.png" height="100px"
                             alt="Best">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                             viewBox="0 0 64 64" width="48px" class="mb-30 mt-10 icon svg-primary">
                            <path d="m54 0h-44v21.142l-10 4.193v38.665h64v-38.665l-10-4.193zm-2 2v29.716l-20 12.537-20-12.537v-29.716zm-42 28.462-6.835-4.285 6.835-2.866zm-8 31.538v-34.193l30 18.807 30-18.807v34.193zm58.835-35.823-6.835 4.285v-7.151z"></path>
                            <path d="m21.445 20.832 5.382 3.588-1.909 6.29c-.122.402.021.838.357 1.09.336.254.794.268 1.146.038l5.569-3.637 5.388 3.629c.169.114.364.17.559.17.205 0 .41-.063.584-.188.34-.245.491-.675.38-1.078l-1.744-6.303 5.397-3.599c.366-.245.53-.7.402-1.122-.127-.421-.516-.71-.956-.71h-6.307l-2.757-7.351c-.147-.395-.535-.658-.948-.649-.421.005-.794.273-.933.671l-2.553 7.329h-6.502c-.44 0-.829.289-.957.71-.128.422.036.877.402 1.122zm7.768.168c.426 0 .805-.269.944-.671l1.877-5.389 2.029 5.411c.147.39.52.649.937.649h3.697l-3.252 2.168c-.359.24-.524.683-.409 1.099l1.216 4.392-3.693-2.488c-.334-.224-.77-.227-1.105-.008l-3.822 2.497 1.326-4.369c.128-.422-.035-.878-.402-1.123l-3.253-2.168z"></path>
                        </svg>
                        <h4 class="">Plan 4</h4>
                        <h3 class="mb-20"><strong>$29.99</strong></h3>
                        <p class="mb-30 text-secondary">
                            In our work we try to use only the most convenient and interesting solutions.
                        </p>
                        <a href="{{url('signup')}}" class="btn btn-outline-dark fx-btn-blick"><span>Buy now</span></a>
                    </div>
                </div>
                <div class="col-lg">
                    <div class="content-box bg-default border padding-x2" data-aos="fade" data-aos-easing="ease-in"
                         data-aos-duration="4" data-aos-once="true">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 64 64" height="48px"
                             viewBox="0 0 64 64" width="48px" class="mb-30 mt-10 icon svg-secondary">
                            <path d="m31 14.414v17.586h2v-17.586l6.292 6.293 1.414-1.561-8.001-8.146h-1.414l-8 8.146 1.415 1.488z"></path>
                            <path d="m54 0h-44v21.142l-10 4.193v38.665h64v-38.665l-10-4.193zm-2 2v29.716l-20 12.537-20-12.537v-29.716zm-42 28.462-6.835-4.285 6.835-2.866zm-8 31.538v-34.193l30 18.807 30-18.807v34.193zm58.835-35.823-6.835 4.285v-7.151z"></path>
                        </svg>
                        <h4 class="">Plan 5</h4>
                        <h3 class="mb-20"><strong>$35.99</strong></h3>
                        <p class="mb-30 text-secondary">
                            In our work we try to use only the most convenient and interesting solutions.
                        </p>
                        <a href="{{url('signup')}}" class="btn btn-outline-dark fx-btn-blick"><span>Buy now</span></a>
                    </div>
                </div>
                <div class="col-12" style="">
                    <p class="text-secondary mt-50" style="color: rgb(255, 255, 255);" data-aos="fade"
                       data-aos-easing="ease-in" data-aos-duration="4" data-aos-once="true">*We strive to provide
                        ultimate experience with our AI prompts and tools.</p>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
    <section id="text-3col-4" class="pt-50 pt-md-100 pb-md-50 pt-lg-150 pb-lg-100 light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-50" style="">
                    <h4 class="" style="">Latest AI tools&nbsp;</h4>
                    <h2 class="mb-20" style="color: rgb(136, 33, 149);" data-aos="fade-right" data-aos-easing="ease-in"
                        data-aos-duration="2" data-aos-once="true"><strong class="">All in one App</strong></h2>
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 40 20" width="40"
                         class="svg-secondary">
                        <path d="m0 8h40v4h-40z" fill-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="content-box mb-50" style="">
                        <h4 style="color: rgb(136, 33, 149);" data-aos="fade-up" data-aos-easing="ease-in"
                            data-aos-duration="3" data-aos-once="true"><strong class="">All Your Favorite AI Tools in
                                One Place</strong></h4>
                        <p style="" data-aos="fade-up" data-aos-easing="ease-in" data-aos-duration="2"
                           data-aos-once="true">Say goodbye to manual copy-pasting and streamline your workflow within
                            Top Prompt Engineer System</p>
                    </div>
                    <div class="content-box mb-50" style="">
                        <h4 style="color: rgb(136, 33, 149);" data-aos="fade-up" data-aos-easing="ease-in"
                            data-aos-duration="2" data-aos-once="true"><strong class="">Generate AI Image</strong></h4>
                        <p style="" data-aos="fade-up" data-aos-easing="ease-in" data-aos-once="true">Create custom
                            images for your project with AI powered image generator</p>
                    </div>
                    <div class="content-box mb-50" style="">
                        <h4 style="color: rgb(136, 33, 149);" data-aos="fade-up" data-aos-easing="ease-in"
                            data-aos-duration="2" data-aos-once="true"><strong class="">Speech To Text</strong></h4>
                        <p style="" data-aos="fade-up" data-aos-easing="ease-in" data-aos-duration="2"
                           data-aos-once="true">Transcribe your audio files to text within seconds </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="content-box mb-50" style="">
                        <h4 style="color: rgb(136, 33, 149);" data-aos="fade-up" data-aos-easing="ease-in"
                            data-aos-duration="2" data-aos-once="true"><strong class="">GPT powered AI writer</strong>
                        </h4>
                        <p style="" data-aos="fade-up" data-aos-easing="ease-in" data-aos-duration="2"
                           data-aos-once="true">Increase your productivity and make your vision reality with GPT 4
                            powered AI writer.<br></p>
                    </div>
                    <div class="content-box mb-50" style="">
                        <h4 style="color: rgb(136, 33, 149);" data-aos="fade-up" data-aos-easing="ease-in"
                            data-aos-duration="2" data-aos-once="true"><strong class="">Chat with AI</strong></h4>
                        <p style="" data-aos="fade-up" data-aos-easing="ease-in" data-aos-duration="2"
                           data-aos-once="true">Prompt the AI to chat with you. Ask ChatGPT 4 anything.<br></p>
                    </div>
                    <div class="content-box mb-50">


                    </div>
                </div>
            </div>
        </div>
        <div class="bg-wrap">
            <div class="bg"></div>
        </div>
    </section>
@endsection

