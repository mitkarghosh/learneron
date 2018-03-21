<section class="cart-top">
    <div class="container">
      <h2><?php echo $banner_data->title; ?></h2>
      <p><?php echo $banner_data->sub_title; ?></p>
    </div>
  </section>
  <section class="cart-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-12 faq-cont accordion">
           <div class="accordion f-a-q-wrap">
           <h2>Welcome to Yumlife</h2>
           <div class="accord-wrap">
               <?php 
               if(!empty($faqs_data)){
                    $i = 1;
                    foreach($faqs_data as $faq){
              ?>
               <div class="accordion-section">
                  <a class="accordion-section-title" href="#accordion-<?php echo $i; ?>"><?php echo $faq->question; ?></a>
                   <div id="accordion-<?php echo $i; ?>" class="accordion-section-content open">
                    <p><?php echo $faq->answer; ?></p> 
                  </div>
                  </div>
                  <?php $i++; }
                  }else{
                  ?>
                  <div class="accordion-section">
                  <a class="accordion-section-title"  href="" >
                  <?php
                    echo 'No FAQ Added yet..';
                    ?>
                    </a>
                    </div>
                    <?php
                  }
                  ?>
             </div> 
          </div> 
         </div> 
      </div>
    </div>
  </section>
  <script>
 $('.accordion .accordion-section-title').removeClass('active');
$('.accordion .accordion-section-content').slideUp(0).removeClass('open');
	  
 $(document).ready(function() {
	 
	 
	 $(".accord-wrap").mCustomScrollbar({
    theme:"dark"
});
	 $(".faq-cont .accordion-section-content").mCustomScrollbar({
    theme:"minimal"
});
	 
  function close_accordion_section() {
        $('.accordion .accordion-section-title').removeClass('active');
        $('.accordion .accordion-section-content').slideUp(300).removeClass('open');
		
    }
	//$('.accordion-section:first-child .accordion-section-title').addClass('active');
    //$('.accordion-section:first-child .accordion-section-content').slideDown(0).addClass('open');
 
    $('.accordion-section-title').click(function(e) {
        // Grab current anchor value
        var currentAttrValue = $(this).attr('href');
 
        if($(e.target).is('.active')) {
            close_accordion_section();
        }else {
            close_accordion_section();
 
            // Add active class to section title
            $(this).addClass('active');
            // Open up the hidden content panel
            $('.accordion ' + currentAttrValue).slideDown(300).addClass('open'); 
        }
 
        e.preventDefault();
    });
});
</script>