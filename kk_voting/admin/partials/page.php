<style>
.kk-content{
    padding: 25px;
        border-radius: 10px;
        background: #f3f3f3;
        margin-top: 20px;
}
label.col-sm-2.col-form-label {
    font-weight: 700;
}
</style>


<div class="mr-3 mt-2">
    <div class="kk-header">
        <h2>Questions</h2>
    </div>

    <div class="kk-content">
    <p class="success-alart" style="color: green;"></p> <!-- succcss message show here  -->
        <form class="kk-custom-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Question : </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control"  value="<?= isset($question) ? $question : ''?>" name="question">
                </div>
            </div>
            <?php $i=0 ; foreach($options as $option): ?>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Option <?= $i=$i+1?> : </label>
                <div class="col-sm-5">
                    <input type="text"  class="form-control" name="option_name<?= $option->id?>" value="<?= $option->option_name?>">
                </div>
                 <div class="col-sm-3">
                    <input type="text"  class="form-control" name="output_text<?= $option->id?>" value="<?= $option->output_text?>">
                </div>
                <div class="col-sm-2">
                    <input type="text"  class="form-control" name="option_count<?= $option->id?>" value="<?= $option->count?>">
                </div>
            </div>
            <?php endforeach; ?>

            <div class="form-group">
            <input type="hidden" name="action" value="kk_question_form_submit">
            <?php wp_nonce_field( 'kk_question_form_submit_nonce', 'kk_custom_form_nonce_field' ); ?>
            <button type="submit" class="btn btn-primary kk_submit_btn">Save</button>
        </div>
        </form>

    </div>
    
    <div class="kk-content">
    <h5>ShorCodes</h5>    
    <code>[voting-form]</code>
    <code>[voting-output]</code>

<br><br>

        <form method="post" action="<?php echo admin_url('admin-ajax.php'); ?>">

            <div class="form-group">
            <input type="hidden" name="action" value="kk_export_excel">
            <?php wp_nonce_field( 'kk_export_excel_nonce', 'kk_export_excel_nonce_field' ); ?>
            <button class="btn btn-info" type="submit">Export IP Address</button>
        </div>
        </form>
        


</div>
    
</div>




<script>
jQuery(document).ready(function($) {
	
	$('.kk-custom-form').on('submit', function(e) {
		e.preventDefault();
        $('.kk-alert').text('');
        $('.success-alart').text('');
        $('.kk_submit_btn').text('Saving..');

        var $form = $(this);

        $.post($form.attr('action'), $form.serialize(), function(data) {
          $('.kk_submit_btn').text('Save');
          if(data.error == true){ //if error show error message
            for (var key in data.error_message) {  
              $('.'+key).text(data.error_message[key])
            }
          }else{
            $('.success-alart').text(data.success);

          }
        }, 'json');
	});
 
});
</script>