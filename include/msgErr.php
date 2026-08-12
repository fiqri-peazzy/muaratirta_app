<?php if (count($errors) > 0 && !empty($errors)) : ?>
<script>
<?php foreach ($errors as $err) : ?>
Toastify({
    text: '<?php echo $err ?>',
    duration: 3000,
    gravity: 'top',
    position: 'right',
    className: "error text-white p-3",
    style: {
        background: "#fc5252",


    },
    stopOnFocus: true,
    offset: {
        x: 0, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
        y: 0 // vertical axis - can be a number or a string indicating unity. eg: '2em'
    },
}).showToast();
<?php endforeach; ?>
</script>
<?php endif; ?>