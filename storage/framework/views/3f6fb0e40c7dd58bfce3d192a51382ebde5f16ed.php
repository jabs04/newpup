
<?php
$language_option = settingSession('get')->language_option;
$language_array = languagesArray($language_option);
$files = ["auth", "messages", "pagination", "passwords","validation"];
?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="language_option" class="col-sm-12 form-control-label"><?php echo e(__('messages.language_option')); ?></label>
            <div class="col-sm-12">
                <select class="form-control select2js opt-LANGUAGE" name="language_option[]" id='change_lang'>
                    <?php if(count($language_array) > 0): ?>
                        <?php $__currentLoopData = $language_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lang['id']); ?>" <?php echo e(config('app.locale') == $lang['id']  ? 'selected' : ''); ?> ><?php echo e($lang['title']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="selected_file" class="col-sm-12 form-control-label"><?php echo e(__('messages.select_file')); ?></label>
            <div class="col-sm-12">
                <select class="form-control select2js opt-LANGUAGE" name="selected_file[]" id="selected_file">
                    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" ><?php echo e($value); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="lang-section"></div>
    </div>
</div>
<script>
    function getLangFile(lang='', file=''){
        var url = "<?php echo e(route('getLangFile')); ?>";
        $.ajax({
            type: 'post',
            url: url,
            data: {
                'lang':lang,
                'file':file
            },
            success: function(res){
                $('.lang-section').html(res);
            }
        });
    }
    function onloadLang(){
        let selectedLang = $("#change_lang :selected").val();
        let selectedFile = $('#selected_file :selected').val();
        getLangFile(selectedLang,selectedFile)
    }
    $(document).ready(function (){
        onloadLang();   
        $(document).on('change','#change_lang',function(){
            let selectedLang = $("#change_lang :selected").val();
            let selectedFile = $('#selected_file :selected').val();
            getLangFile(selectedLang,selectedFile)
        });  
        $(document).on('change','#selected_file',function(){
            let selectedLang = $("#change_lang :selected").val();
            let selectedFile = $('#selected_file :selected').val();
            getLangFile(selectedLang,selectedFile)
        });        
    });
</script>
<?php /**PATH C:\xampp\htdocs\newpup\resources\views/setting/language-setting.blade.php ENDPATH**/ ?>