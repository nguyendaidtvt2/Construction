<?php if ($links) :
    // Custom icon/text
    $links['prev_text'] = '<i class="la la-angle-left" aria-hidden="true"></i>';
    $links['next_text'] = '<i class="la la-angle-right" aria-hidden="true"></i>';
    ?>
    <div class="pagi-nav <?php echo esc_attr($style)?>">
        <?php echo apply_filters('th_output_content',paginate_links($links)); ?>
    </div>
<?php endif;?>