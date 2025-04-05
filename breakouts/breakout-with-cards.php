<!-- 
ALSO WORKS WITH REVIEWS IF DATA IS FILLED WITHIN CARD SHORTCODE

[breakout_card_grid image_src="bg.jpg" sub_header="sub_header" header="header"]
    [breakout_card header="header" reviews="" pid=""] content [/breakout_card]
[/breakout_card_grid] 

-->

// Global container to hold nested cards temporarily
<?php 

global $breakout_card_grid_cards;
$breakout_card_grid_cards = [];

function breakout_card_shortcode($atts, $content = null) {
    global $breakout_card_grid_cards;

    $atts = shortcode_atts([
        'header' => '',
        'reviews' => '',
        'pid' => ''
    ], $atts);

    // Save each card as an array
    $breakout_card_grid_cards[] = [
        'header'  => $atts['header'],
        'reviews'  => $atts['reviews'],
        'pid'  => $atts['pid'],
        'content' => do_shortcode($content),
    ];

    return ''; // Don't render here — it will be rendered by the parent
}
add_shortcode('breakout_card', 'breakout_card_shortcode');

function breakout_card_grid_shortcode($atts, $content = null) {
    global $breakout_card_grid_cards;
    $breakout_card_grid_cards = []; // Reset before processing

    $atts = shortcode_atts([
        'image_src'  => '',
        'sub_header' => '',
        'header'     => '',
    ], $atts);

    // Process nested shortcodes (collect cards)
    do_shortcode($content);

    ob_start();
    ?>
    <div class="breakout text-center" style="background-image: url('<?php echo esc_url($atts['image_src']); ?>');" id="wrap_container">
        <div class="large-wrapper">
            <?php if (!empty($atts['sub_header'])): ?>
                <b class="spaced"><?php echo esc_html($atts['sub_header']); ?></b>
            <?php endif; ?>

            <?php if (!empty($atts['header'])): ?>
                <h2><?php echo esc_html($atts['header']); ?></h2>
            <?php endif; ?>

            <div class="row container-fluid justify-content-center">
                <?php foreach ($breakout_card_grid_cards as $card): ?>
                    <div class="w-100">
                        <div class="wrap">

                            <?php if (!empty($card['reviews'])): ?>
                                <img src="/wp-content/uploads/google.png" alt="Google" width="40" height="40" class="alignnone size-full brand" />
                                <img src="/wp-content/uploads/stars.webp" alt="Stars" width="500" height="138" class="alignnone size-full stars" />
                            <?php endif; ?>

                            <?php if (!empty($card['header'])): ?>
                                <h3><?php echo esc_html($card['header']); ?></h3>
                            <?php endif; ?>

                            <?php echo wp_kses_post($card['content']); ?>

                            <?php if (!empty($card['pid'])): ?>
                                <a class="btn" title="Leave a review!" href="https://search.google.com/local/writereview?placeid=<?php echo esc_html($card['pid']); ?>" target="_blank" rel="noopener noreferrer">Leave a review</a>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode('breakout_card_grid', 'breakout_card_grid_shortcode');


?>
