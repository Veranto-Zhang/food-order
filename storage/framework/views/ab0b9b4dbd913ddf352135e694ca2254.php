<?php $__env->startSection('content'); ?>

  <div id="Background" class="absolute top-0 w-full h-[230px] rounded-b-[75px] bg-[linear-gradient(180deg,#FFF3E0_0%,#FFE0C7_100%)]"></div>
  <div id="TopNav" class="relative flex items-center justify-between px-4 my-[30px]">
      <a href="<?php echo e(route('home')); ?>"
          class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white">
          <img src="<?php echo e(asset('assets/images/icons/arrow-left.svg')); ?>" class="w-[28px] h-[28px]" alt="icon">
      </a>
      <div class="flex flex-col items-center">
          <h1 class="font-semibold text-lg">Your Cart</h1>
      </div>
      <div class="dummy-btn w-14"></div>
  </div>

  <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('cart-component');

$__html = app('livewire')->mount($__name, $__params, 'lw-1442572343-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/js/cart.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\food-order\resources\views/pages/order/cart.blade.php ENDPATH**/ ?>