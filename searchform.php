<form role="search" method="get" id="searchform" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
        <label for="s" class="show-for-sr"><?php _e('Search for:','bonestheme'); ?></label>
        <input type="search" id="s" name="s" value="" />

        <button type="submit" id="searchsubmit" class="button" ><?php _e('Search','bonestheme'); ?></button>
    </div>
</form>