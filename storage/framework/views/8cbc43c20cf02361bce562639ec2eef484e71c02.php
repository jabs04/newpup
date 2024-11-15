<?php if(isset($query->providers)): ?>
<?php if(auth()->user()->can('providerdocument edit')): ?>
<a href="<?php echo e(route('providerdocument.create', ['id' => $query->id])); ?>">
  <div class="d-flex gap-3 align-items-center">
    <img src="<?php echo e(getSingleMedia(optional($query->providers),'profile_image', null)); ?>" alt="avatar" class="avatar avatar-40 rounded-pill">
    <div class="text-start">
      <h6 class="m-0"><?php echo e(optional($query->providers)->display_name); ?> </h6>
      <span><?php echo e(optional($query->providers)->email ?? '--'); ?></span>
    </div>
  </div>
</a>
<?php else: ?>

 <div class="d-flex gap-3 align-items-center">
    <img src="<?php echo e(getSingleMedia(optional($query->providers),'profile_image', null)); ?>" alt="avatar" class="avatar avatar-40 rounded-pill">
    <div class="text-start">
      <h6 class="m-0 tn-link btn-link-hover"><?php echo e(optional($query->providers)->display_name); ?> </h6>
      <span class="btn-link btn-link-hover"><?php echo e(optional($query->providers)->email ?? '--'); ?></span>
    </div>
  </div>

  <?php endif; ?>
  <?php else: ?>
  <div class="align-items-center">
    <h6 class="text-center"><?php echo e('-'); ?> </h6>
</div>
  <?php endif; ?>




<?php /**PATH C:\xampp\htdocs\newpup\resources\views/providerdocument/user.blade.php ENDPATH**/ ?>