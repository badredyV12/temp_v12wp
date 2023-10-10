<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Essential_Elementor_Loop_Item_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'loop item';
	}

	public function get_title() {
		return esc_html__( 'Loop Item', 'essential-elementor-widget' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_custom_help_url() {
		return 'https://exapmple.com/';
	}

	public function get_categories() {
		return [ "general" ];
	}

	public function get_keywords() {
		return [ 'loop item', "v12" ];
	}

    protected function render() {
        // Enqueue Swiper and Bootstrap libraries
        wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', array('jquery'), '', true);;
        wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');

        ?>
        <section class="clickble_slider1">
            <div class="container py-4">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Swiper -->
                        <div class="row">
                            <div class="col-md-12 px-0 py-2">
                                <div class="swiper swiper_large_preview" >
                                    <div class="swiper-wrapper">

                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/24081/1060/945121692799045.jpg" />
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/24081/1060/945121692799045.jpg" />
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/800x600" />
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/800x600" />
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/800x600" />
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/800x600" />
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="swiper-pagination"></div>

                                </div>
                            </div>
                            <div class="col-md-12 px-0 py-2">
                                <div thumbsSlider="" class="swiper swiper_thumb">

                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/24081/1060/945121692799045.jpg" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://res.cloudinary.com/pwappd/image/upload/w_800,h_600/24081/1060/945121692799045.jpg" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/150x100" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/150x100" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/150x100" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="zoom_img">
                                                <img class="img-fluid" src="https://placehold.co/150x100" />
                                            </div>
                                        </div>

                                    </div>
<!--                                    <div class="swiper-button-next"></div>-->
<!--                                    <div class="swiper-button-prev"></div>-->
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </section>

        <style>
            .swiper {
                width: 100%;
                height: 100%;
            }

            .swiper-slide {
                text-align: center;
                font-size: 18px;
                background: #fff;
                /* Center slide text vertically */
                display: -webkit-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                -webkit-justify-content: center;
                justify-content: center;
                -webkit-box-align: center;
                -ms-flex-align: center;
                -webkit-align-items: center;
                align-items: center;
                cursor: pointer;
            }

            .swiper-slide img {
                display: block;
                width: 100%;
                /* height: 100%;
                object-fit: cover; */
            }

            .swiper {
                width: 100%;
            }



            .swiper_thumb .swiper-slide {
                opacity: 0.7;
            }

            .swiper_thumb .swiper-slide:hover {
                opacity: 1;
            }

            .swiper_thumb .swiper-slide-thumb-active {
                opacity: 1;
                border: 2px solid #6d12ff;
            }

            .swiper-slide img {
                display: block;
                width: 100%;
                /* height: 100%;
                object-fit: cover; */
                user-select: none;
            }

            .swiper-button-next,
            .swiper-button-prev {
                padding: 20px;
                color: white;
                background: rgba(0, 0, 0, .8);
                width: 20px;
                height: 20px;
                /* border-radius: 50%; */
                /* box-shadow: 0px 2px 2px rgb(221 56 34); */
                z-index: 9;
            }

            .swiper-button-next,
            .swiper-button-prev::after {
                font-size: 20px;
                font-weight: 800;
            }

            .swiper-button-prev,
            .swiper-button-next::after {
                font-size: 20px;
                font-weight: 800;
            }

            .swiper-button-next {
                right: 0px;
            }

            .swiper-button-prev {
                left: 0px;
            }

            .swiper-button-next:hover {
                color: #fff;
                background: #6d12ff;
            }

            .swiper-button-prev:hover {
                color: #fff;
                background: #6d12ff;
            }

            .img-fluid {
                cursor: pointer;
                opacity: 0.6;
            }

            .active, .img-fluid:hover {

                opacity: 1;
            }
            .swiper-pagination-bullet{

                background:#6d12ff;
            }
            .zoom_img {
                position: relative;
                display: inline-block;
            }

            .swiper-button-next,
            .swiper-button-prev {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                color: white;
                background: rgba(0, 0, 0, .8);
                width: 20px;
                height: 20px;
                font-size: 20px;
                font-weight: 800;
                cursor: pointer;
                z-index: 9;
            }

            .swiper-button-next {
                right: 0px;
            }

            .swiper-button-prev {
                left: 0px;
            }
            .swiper_large_preview {
                width: 100%; /* Set the carousel width to 100% */
            }

        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var swiper = new Swiper(".swiper_thumb", {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    speed: 300,
                    loop: true,
                    freeMode: true,
                    watchSlidesProgress: true,
                    ClickAble: true,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });

                var swiperLargePreview = new Swiper(".swiper_large_preview", {
                    spaceBetween: 10,
                    slidesPerView: 1,
                    speed: 0,
                    loop: true,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    pagination: {
                        el: ".swiper-pagination", // Add pagination dots here
                        clickable: true,
                    },
                    thumbs: {
                        swiper: swiper,
                    },
                });
            });
        </script>
        <?php
    }





}