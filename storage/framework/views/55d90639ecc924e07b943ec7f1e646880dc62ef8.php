<?php if(isset($query->id)): ?>
<a href="<?php echo e(route('user.show', ['user' => $query->id])); ?>">
  <div class="d-flex gap-3 align-items-center">
    <img src="<?php echo e(getSingleMedia($query,'profile_image', null)); ?>" alt="avatar" class="avatar avatar-40 rounded-pill">
    <div class="text-start">
      <h6 class="m-0"><?php echo e($query->first_name); ?> <?php echo e($query->last_name); ?></h6>
      <span><?php echo e($query->email ?? '--'); ?></span>
    </div>
  </div>
</a>

<?php else: ?>

<div class="align-items-center">
    <h6 class="text-center"><?php echo e('-'); ?> </h6>
</div>
<?php endif; ?>


<?php /**PATH C:\xampp\htdocs\newpup\resources\views/customer/user.blade.php ENDPATH**/ ?>