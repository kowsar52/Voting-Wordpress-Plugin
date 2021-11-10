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



<div class="after_vote">
    <ul>
    <?php $i=0 ; foreach($options as $option){ ?>
        <li style="text-align:center;    padding: 0px !important;
    margin: 0px !important;
    border-top: 1px solid #ececec;">
			<p style="font-size: 50px;font-weight: 700;text-align:center"><?= $option->count?></p>
            <strong style="font-weight: 700;
    font-size: 26px;
    top: -20px;
    position: relative;
"><?= $option->output_text ?></strong>
        </li>
    <?php } ?>
    </ul>
</div>


