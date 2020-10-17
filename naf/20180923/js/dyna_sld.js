// JavaScript Document
$( document ).ready(function() {

// Initialize the carousels
            var owl = $('.owl-carousel');
            var owlPta = $('.owl-carousel-pta');
			owl.owlCarousel();
            owlPta.owlCarousel();
            var lastItemIndexTestimonial = 0;
            var lastItemIndexPta = 0;
            var testimonialTotalCount = 0;
            var ptaTotalCount = 0;
            var ptaArray = [];
            var ptaCarousel="";
            var firstPtaArray=[];
            var testimonialCarousel="";
            $.ajax({
                url: "https://www.indianpac.com/naf/home/getTotalTestimonialCount",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    testimonialTotalCount = result.length;
                }
            });
            $.ajax({
                url: "https://www.indianpac.com/naf/home/getPTA",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
                    ptaTotalCount = result.length;
                    ptaArray = result;

                    // get first 7 pta from ptaArray;
                    firstPtaArray = ptaArray.slice(0,7);
                    owlPta.trigger('destroy.owl.carousel');
                    owlPta.find('.owl-stage-outer').children().unwrap();
                    owlPta.removeClass("owl-center owl-loaded owl-text-select-on");
                    $.each(firstPtaArray, function( index, value ) {
                        ptaCarousel += "<div class=\"item\" style=\"text-align: center\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/top_pta_performers/" + value.image_id + ".jpg\" style=\"height: 200px;width: 200px;border-radius: 50%;margin: 20px auto;\"/><div class=\"pta-font pta_font_title\">" + value.name + "</div><div class=\"pta-font\" style=\"margin: 10px 0;\">" + value.college_name + "</div></div>";
                        lastItemIndexPta = index + 1;
                    });
                    owlPta.html(ptaCarousel);
                    //reinitialize the carousel (call here your method in which you've set specific carousel properties)
                    owlPta.owlCarousel({
                        items: 5,
                        loop: true,
                        margin: 10,
                        responsive: {
                            0: {
                                loop: true,
                                items: 1,
                                nav: false,
                            },
                            600: {
                                loop: true,
                                items: 3,
                                nav: false,
                            },
                            1000: {
                                loop: true,
                                items: 5,
                                nav: false,
                            },
                            1100: {
                                loop: true,
                                items: 6,
                                nav: false,
                            }
                        }
                    });
                }
            });


            // make the API call get first 4 rows from DB
            $.ajax({
                url: "https://www.indianpac.com/naf/home/getTestimonials",
                dataType: "JSON",
                type: "GET",
                cache: false,
                contentType: false,
                processData: false,
                success: function(result) {
					owl.trigger('destroy.owl.carousel');
                    owl.find('.owl-stage-outer').children().unwrap();
                    owl.removeClass("owl-center owl-loaded owl-text-select-on");
                    // add the new items
                    $.each(result, function( index, value ) {
                        testimonialCarousel += "<div class=\"item-testimonial" + ' ' + value.bg_color + "\" id=\"testimonial\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/"+ value.author_image +"\" style=\"height: 200px;width: 200px;border-radius: 50%;margin: 20px auto;\"/><div class=\"testimonial-author-name\">" + value.author + "</div><div class=\"testimonial-author-name designation-testimonial\">" + value.designation + "</div><div class=\"testimonial-content\"><i class=\"fa fa-quote-left\" style=\"font-size:16px;margin-right: 5px;margin-right: 5px;color: #767676;\"></i>" + value.testimonial + "<i class=\"fa fa-quote-right\" style=\"font-size:16px;margin-left: 5px;margin-right: 5px;color: #767676;\"></i></div></div>"
                        lastItemIndexTestimonial = parseInt(value.id);
                    });
                    owl.html(testimonialCarousel);
                    //reinitialize the carousel (call here your method in which you've set specific carousel properties)
                    owl.owlCarousel({
                        dots: false,
                        loop: true,
                        items: 3,
                        margin: 30,
                        slideTransition:'linear',
                        responsive: {
                            0: {
                                items: 1,
                                nav: false,
                                loop: true,
                            },
                            600: {
                                items: 1,
                                nav: false,
                                loop: true,
                            },
                            1000: {
                                loop: true,
                                items: 3,
                                nav: false,
                                animateOut: 'fadeOut',
                                animateIn: 'fadeIn',
                            }
                        }
                    });

                }
            });

            // Go to the next item
            $('.customNextBtnTestimonial').click(function() {

                if(lastItemIndexTestimonial === testimonialTotalCount){
                    owl.trigger('next.owl.carousel', [300]);
                    return;
                }
                $.ajax({
                    url: "https://www.indianpac.com/naf/home/next_testimonials",
                    data: {'item_count':lastItemIndexTestimonial},
                    dataType: "JSON",
                    type: "POST",
                    success: function(result) {
                        // console.log(result);
                        $.each(result, function( index, value ) {
                            testimonialCarousel = "<div class=\"item-testimonial" + ' ' + value.bg_color + "\" id=\"testimonial\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/"+ value.author_image +"\" style=\"height: 200px;width: 200px;border-radius: 50%;margin: 20px auto;\"/><div class=\"testimonial-author-name\">" + value.author + "</div><div class=\"testimonial-author-name designation-testimonial\">" + value.designation + "</div><div class=\"testimonial-content\"><i class=\"fa fa-quote-left\" style=\"font-size:16px;margin-right: 5px;margin-right: 5px;color: #767676;\"></i>" + value.testimonial + "<i class=\"fa fa-quote-right\" style=\"font-size:16px;margin-left: 5px;margin-right: 5px;color: #767676;\"></i></div></div>";
                            owl.trigger('add.owl.carousel',[testimonialCarousel]).trigger('refresh.owl.carousel');
                            lastItemIndexTestimonial = parseInt(value.id);
                        });


                        owl.trigger('next.owl.carousel', [300]);
                    }
                });

            });
            // Go to the next item
            var nextPtaIndexForSlice = 0;
            $('.customNextBtnPta').click(function() {
                if(lastItemIndexPta === ptaTotalCount){
					owlPta.trigger('next.owl.carousel', [300]);
                    return;
                }
                // I have last index
                $.each(ptaArray, function(index, value){
                    if(index === lastItemIndexPta){
                        nextPtaIndexForSlice = index;
                    }
                });

                var nextPtaArray = ptaArray.slice(nextPtaIndexForSlice, nextPtaIndexForSlice + 1);

                $.each(nextPtaArray, function( index, value ) {
                    ptaCarousel = "<div class=\"item\" style=\"text-align: center\"><img src=\"https://www.indianpac.com/naf/assets/images/top_pta_performers/" + value.image_id + ".jpg\" style=\"height: 200px;width: 200px;border-radius: 50%;margin: 20px auto;\"/><div class=\"pta-font pta_font_title\">" + value.name + "</div><div class=\"pta-font\" style=\"margin: 10px 0;\">" + value.college_name + "</div></div>";
                    owlPta.trigger('add.owl.carousel',[ptaCarousel]).trigger('refresh.owl.carousel');
                    lastItemIndexPta++;
                });
                owlPta.trigger('next.owl.carousel', [300]);
            });
            // Go to the previous item
            $('.customPrevBtnTestimonial').click(function() {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                if(testimonialTotalCount === lastItemIndexTestimonial){
                    owl.trigger('prev.owl.carousel', [300]);
                    return;
                }else{
                    $.ajax({
                        url: "https://www.indianpac.com/naf/home/next_testimonials",
                        data: {'item_count':lastItemIndexTestimonial},
                        dataType: "JSON",
                        type: "POST",
                        success: function(result) {
                            console.log(result);
                            $.each(result, function( index, value ) {
                                testimonialCarousel = "<div class=\"item-testimonial" + ' ' + value.bg_color + "\" id=\"testimonial\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/"+ value.author_image +"\" style=\"height: 200px;width: 200px;border-radius: 50%;margin: 20px auto;\"/><div class=\"testimonial-author-name\">" + value.author + "</div><div class=\"testimonial-author-name designation-testimonial\">" + value.designation + "</div><div class=\"testimonial-content\"><i class=\"fa fa-quote-left\" style=\"font-size:16px;margin-right: 5px;margin-right: 5px;color: #767676;\"></i>" + value.testimonial + "<i class=\"fa fa-quote-right\" style=\"font-size:16px;margin-left: 5px;margin-right: 5px;color: #767676;\"></i></div></div>";
                                owl.trigger('add.owl.carousel',[testimonialCarousel]).trigger('refresh.owl.carousel');
                                lastItemIndexTestimonial = parseInt(value.id);
                            });
                            owl.trigger('prev.owl.carousel', [300]);

                        }
                    });
                }


            });

            // Go to the previous item
            $('.customPrevBtnPta').click(function() {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                if(ptaTotalCount === lastItemIndexPta){
					owlPta.trigger('prev.owl.carousel', [300]);
                    return;
                }
                // I have last index
                $.each(ptaArray, function(index, value){
                    if(index === lastItemIndexPta){
                        nextPtaIndexForSlice = index;
                    }
                });

                var nextPtaArray = ptaArray.slice(nextPtaIndexForSlice, nextPtaIndexForSlice + 1);

                $.each(nextPtaArray, function( index, value ) {
                    ptaCarousel = "<div class=\"item\" style=\"text-align: center\"><img src=\"https://res.cloudinary.com/indianpac/image/upload/naf/images/top_pta_performers/" + value.image_id + ".jpg\" style=\"height: 200px;width: 200px;border-radius: 50%;margin: 20px auto;\"/><div class=\"pta-font pta_font_title\">" + value.name + "</div><div class=\"pta-font\" style=\"margin: 10px 0;\">" + value.college_name + "</div></div>";
                    owlPta.trigger('add.owl.carousel',[ptaCarousel]).trigger('refresh.owl.carousel');
                    lastItemIndexPta++;
                });
                owlPta.trigger('prev.owl.carousel', [300]);
            });
			});