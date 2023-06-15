<?php if($editor_enabled): ?>

<?php if($codemirror_enabled): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/<?php echo e(Kordy\Ticketit\Helpers\Cdn::CodeMirror); ?>/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/<?php echo e(Kordy\Ticketit\Helpers\Cdn::CodeMirror); ?>/mode/xml/xml.min.js"></script>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/<?php echo e(Kordy\Ticketit\Helpers\Cdn::Summernote); ?>/summernote-bs4.min.js"></script>
<?php if($editor_locale): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/<?php echo e(Kordy\Ticketit\Helpers\Cdn::Summernote); ?>/lang/summernote-<?php echo e($editor_locale); ?>.min.js"></script>
<?php endif; ?>
<script>


    $(function() {

        var options = $.extend(true, {lang: '<?php echo e($editor_locale); ?>' <?php echo $codemirror_enabled ? ", codemirror: {theme: '{$codemirror_theme}', mode: 'text/html', htmlMode: true, lineWrapping: true}" : ''; ?> } , <?php echo $editor_options; ?>);

        $("textarea.summernote-editor").summernote(options);

        $("label[for=content]").click(function () {
            $("#content").summernote("focus");
        });
    });


</script>
<?php endif; ?><?php /**PATH D:\xamp-php-v.7.4\htdocs\ticketit\vendor\kordy\ticketit\src/Views/bootstrap4/tickets/partials/summernote.blade.php ENDPATH**/ ?>