<div class="z-10">
    <!--[if BLOCK]><![endif]--><?php if(count($cart) > 0): ?>
        <!-- Cart Items -->
        <div class="flex flex-col gap-4 px-4 py-4">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white p-3 rounded-xl flex items-center justify-between border border-gray-200 shadow-sm hover:shadow-md transition">
                    
                    <!-- Thumbnail -->
                    <div class="w-24 h-24 flex shrink-0 rounded-xl overflow-hidden border">
                        <img src="<?php echo e(asset('storage/' . $item['image'])); ?>" 
                             class="w-full h-full object-cover object-center" 
                             alt="<?php echo e($item['menu_name']); ?>">
                    </div>

                    <!-- Item Info -->
                    <div class="flex flex-col flex-1 pl-4 gap-2">
                        <p class="font-semibold text-gray-900 text-sm md:text-lg"><?php echo e($item['menu_name']); ?></p>

                        <!-- Options -->
                        <!--[if BLOCK]><![endif]--><?php if(!empty($item['options'])): ?>
                            <div class="text-xs text-gray-500">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $item['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p>
                                        <?php echo e($opt['group']); ?>: <?php echo e($opt['name']); ?>

                                        <!--[if BLOCK]><![endif]--><?php if($opt['extra'] > 0): ?>
                                            <span class="text-gray-400">(+Rp <?php echo e(number_format($opt['extra'])); ?>)</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!-- Price + Quantity -->
                        <div class="flex justify-between items-center mt-1">
                            <p class="font-semibold text-primary text-sm md:text-lg">
                                Rp <?php echo e(number_format($item['itemPrice'], 0, ',', '.')); ?>

                            </p>

                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-1">
                                <!-- Remove Item -->
                                <button wire:click="removeItem('<?php echo e($key); ?>')" 
                                        class="text-red-500 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>

                                <!-- Decrease -->
                                <button wire:click="decreaseQty('<?php echo e($key); ?>')" 
                                        class="w-6 h-6 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100">
                                    −
                                </button>

                                <!-- Quantity -->
                                <span class="w-6 text-center text-sm font-medium text-gray-800">
                                    <?php echo e($item['quantity']); ?>

                                </span>

                                <!-- Increase -->
                                <button wire:click="increaseQty('<?php echo e($key); ?>')" 
                                        class="w-6 h-6 flex items-center justify-center rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Add Item Button -->
        <div class="px-4 pb-4">
            <a href="<?php echo e(route('home')); ?>" 
               class="block w-full bg-orange-100 text-orange-600 text-sm font-normal text-center px-6 py-3 rounded-xl ">
                + Add More Item
            </a>
        </div>

        <!-- Promo Code -->
        <div class="px-4">
            <p class="font-semibold text-lg mt-4 mb-2">Promo Code</p>
            <div class="flex gap-2">
                <input 
                    type="text" 
                    wire:model.defer="promo_code" 
                    class="w-full rounded-xl bg-white p-[16px_24px] border 
                                focus:border-orange-500 focus:outline-none uppercase"
                    placeholder="Enter Promo Code"
                >
                <button wire:click="applyPromo" class="px-6 rounded-xl bg-[#ff914d] text-white font-medium">
                    Applys
                </button>
            </div>

            <!--[if BLOCK]><![endif]--><?php if($promoError): ?>
                <div class="mt-2 text-sm text-red-500"><?php echo e($promoError); ?></div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($promoSuccess): ?>
                <div class="mt-2 text-sm text-green-500"><?php echo e($promoSuccess); ?></div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Order Summary -->
        <div class="px-4 mt-6">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-3">
                <p class="font-semibold text-gray-900 text-md">Order Summary</p>

                <div class="flex justify-between text-sm text-gray-700">
                    <span>Subtotal</span>
                    <span class="font-semibold">Rp <?php echo e(number_format($this->subtotal, 0, ',', '.')); ?></span>
                </div>

                <div class="flex justify-between text-sm text-gray-700">
                    <span>Tax (11%)</span>
                    <span class="font-semibold">Rp <?php echo e(number_format($this->tax, 0, ',', '.')); ?></span>
                </div>
                
                <!--[if BLOCK]><![endif]--><?php if($discount > 0): ?>
                    <div class="flex justify-between text-green-600 font-medium">
                        <span>Discount</span>
                        <span>- Rp <?php echo e(number_format($discount, 0, ',', '.')); ?></span>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <hr class="border-gray-200">

                <div class="flex justify-between text-md font-semibold text-gray-900">
                    <span>Total</span>
                    <span class="font-semibold">Rp <?php echo e(number_format($this->grandTotal, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        <!-- Bottom Nav -->
        <div id="BottomNav" class="fixed bottom-4 w-full max-w-[640px] mx-auto px-4 z-10">
            <div class="rounded-xl p-4 bg-[#ff914d] flex items-center justify-between shadow-lg">
                <div class="flex flex-col text-white">
                    <span class="text-sm">Total</span>
                    <span class="font-semibold text-lg">Rp <?php echo e(number_format($this->grandTotal, 0, ',', '.')); ?></span>
                </div>
                <a href="<?php echo e(route('checkout')); ?>" 
                   class="bg-white text-gray-700 px-5 py-3 rounded-lg font-medium shadow hover:bg-orange-100 transition">
                    Place Order
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <section id="EmptyCart" class="flex flex-col p-4 gap-4">
            <div class="w-full h-[240px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
              <img src="<?php echo e(asset('assets/images/empty-cart.png')); ?>" class="w-full h-full object-cover object-center" alt="background">
              <p class="text-gray-500 text-lg">Your cart is empty</p>
            </div>
        </section>

        <!-- Add Item Button -->
        <div class="px-4 pb-4">
            <a href="<?php echo e(route('pages.menu.all')); ?>" 
               class="block w-full bg-orange-100 text-orange-600 text-sm font-normal text-center px-6 py-3 rounded-xl ">
                Order Now
            </a>
        </div>

        <?php echo $__env->make('includes.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\laragon\www\food-order\resources\views/livewire/cart-component.blade.php ENDPATH**/ ?>