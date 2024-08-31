(function($) {
    let RatingWidget = {
        init: function() {
            $('.rating-widget').each(function() {
                let $widget = $(this);
                let ratingScale = $widget.data('rating-scale');
                let rating = $widget.data('rating');
                let $iconsContainer = $widget.find('.rating-icons');
                console.log($widget)
                RatingWidget.renderIcons($iconsContainer, ratingScale, rating);
            });
        },

        renderIcons: function($container, scale, rating) {
            $container.empty();

            for (let i = 1; i <= scale; i++) {
                let $icon = $('<i>').addClass('rating-icon');

                if (i <= Math.floor(rating)) {
                    $icon.addClass('marked');
                } else if (i === Math.ceil(rating) && !Number.isInteger(rating)) {
                    $icon.addClass('partial');
                } else {
                    $icon.addClass('unmarked');
                }

                $container.append($icon);
            }
        }
    };

    $(document).ready(RatingWidget.init);
})(jQuery);