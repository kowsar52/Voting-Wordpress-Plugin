<style>
.after_vote ul{
    margin:0px;
    padding:0px;
}
.after_vote li {
    list-style: none;
    padding: 11px 0px;
    margin: 0px;
    display: block;
}
	.kk-box{
		height: 15px;
    width: 15px;
    background: #676767;
    display: inline-flex;
    margin: -2px 10px;
	}
</style>



<p class="kk-alart-success" style="color:green"></p>
<h3><?= isset($question) ? $question: '' ?></h3>

<form class="kk-custom-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
    <?php $i=0 ; foreach($options as $option): ?>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="option_<?= $option->id?>" name="id" value="<?= $option->id?>">
            <label class="form-check-label" for="option_<?= $option->id?>"><?= $option->option_name?></label>
        </div>
        <?php endforeach; ?>
  <div class="form-group">
    <input type="hidden" name="action" value="kk_count_form_submit">
    <?php wp_nonce_field( 'kk_count_form_submit_nonce', 'kk_count_form_submit_nonce_field' ); ?>
     <button type="submit" class="btn btn-primary kk_submit_btn">Submit</button>
  </div>


</form>



<script>
jQuery("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = jQuery(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    jQuery(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});


jQuery(document).ready(function($) {
	
	$('.kk-custom-form').on('submit', function(e) {
		e.preventDefault();
        $('.kk-alert').text('');
        $('.success-alart').text('');
        $('.kk_submit_btn').text('Sending..');

        var $form = $(this);

        $.post($form.attr('action'), $form.serialize(), function(data) {
          if(data.error == true){ //if error show error message
            for (var key in data.error_message) {  
              $('.'+key).text(data.error_message[key])
            }
          }else if(data.error2){
            jQuery('.kk-alart-success').text(data.error2)
            $('.kk_submit_btn').text('Submited');

          }else if(data.success){
              jQuery('.kk-alart-success').text(data.success)
               $('.kk_submit_btn').text('Submited');
          }
        }, 'json');
	});
 
});
</script>