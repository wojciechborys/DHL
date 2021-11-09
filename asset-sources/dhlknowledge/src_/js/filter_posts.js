import $ from "jquery";

jQuery(document).ready(function ($) {

    $(document).on("click", ".js-click-filter", function () {
            if ($(this).hasClass('active')) {
                $('.js-click-filter').removeClass('active');
                var term_id = $(this).data('parentid');
            } else {
                $('.js-click-filter').removeClass('active');
                $(this).addClass('active');
                var term_id = $(this).data('id');
            }

            var category = 'posts';
            if ($(this).hasClass('documents')) {
                category = 'documents';
            } else if ($(this).hasClass('faqs')) {
                category = 'faqs';
            }

            $.ajax({
                type: 'POST',
                url: sd_config.ajax_url,
                cache: true,
                dataType: 'JSON',
                status: 200,
                data: {
                    action: 'filter_posts',
                    category: category,
                    term_id: term_id,
                },
                beforeSend: function beforeSend() {
                    //show loading indicator
                },
                success: function (data) {
                    let append_data = $('#knowledgePosts').html(data.data);
                    append_data.promise().done(() => {
                        if ($('#knowledgePosts.faqs').length > 0) {
                            let accordion_el = $('#knowledgePosts.faqs').find('.collapse.show');
                            console.log(accordion_el);
                            for (let i = 0; i <= accordion_el.length; i++) {
                                // console.log(accordion_el[i]);
                                $(accordion_el[i]).removeClass('show');
                            }
                        }
                    });
                },
                async: true
            });
        }
    );

    $(document).on('click', '.pagination a', function (event) {
        event.preventDefault();

        if ($(this).hasClass('next')) {
            var page = find_page_number($(this).parent().prev().find('a').clone());
        } else {
            var page = find_page_number($(this).clone());
        }

        var category = 'posts';
        if ($('#knowledgePosts').hasClass('documents')) {
            category = 'documents';
        } else if ($('#knowledgePosts').hasClass('faqs')) {
            category = 'faqs';
        }

        var catSlug = "";

        if ($('.js-click-filter').hasClass('active')) {
            catSlug = $('.js-click-filter.active').data('slug');
        }

        console.log(catSlug);

        $.ajax({
            url: sd_config.ajax_url,
            type: 'post',
            data: {
                action: 'ajax_pagination',
                query_vars: sd_config.query_vars,
                page: page,
                'first_page': sd_config.first_page,
                category: category,
                cat_slug: catSlug
            },
            beforeSend: function () {
                $('#knowledgePosts nav').remove();
                $(document).scrollTop();
                // $('#knowledgePosts').append( '<div class="page-content" id="loader">Loading New Posts...</div>' );
            },
            success: function (data) {
                console.log(data);
                //   $('#knowledgePosts #loader').remove();
                $('#knowledgePosts').html("");
                let append_data = $('#knowledgePosts').append(data);
                append_data.promise().done(() => {
                    if ($('#knowledgePosts.faqs').length > 0) {
                        let accordion_el = $('#knowledgePosts.faqs').find('.collapse.show');
                        console.log(accordion_el);
                        for (let i = 0; i <= accordion_el.length; i++) {
                            // console.log(accordion_el[i]);
                            $(accordion_el[i]).removeClass('show');
                        }
                    }
                });
            }
        });
    });

    function find_page_number(element) {
        element.find('span').remove();
        return parseInt(element.html());
    }

    $(document).on("click", ".js-search-filter", function () {

        $('.js-search-filter').removeClass('active');
        $(this).addClass('active');
        let type = $(this).data('type');

        $('.search-posts').addClass('d-none');
        $(`#${type}`).removeClass('d-none');

    });


    $(document).on("click", ".js-search-more", function () {

        var el = $(this).parent().parent();
        let post_id = $(this).data('id');
        let category = $(this).attr('id');
        let offset = $(this).data('offset');
        let search = $(this).data('search');
        console.log('test');
        $.ajax({
            type: 'POST',
            url: sd_config.ajax_url,
            cache: true,
            dataType: 'JSON',
            status: 200,
            data: {
                action: 'search_more_posts',
                category: category,
                post_id: post_id,
                offset: offset,
                search: search,
            },
            beforeSend: function beforeSend() {
                //show loading indicator
            },
            success: function (data) {
                console.log(data);
                el.find('.button_container').remove();
                el.append(data.data);
            },
            async: true
        });
    });

});

