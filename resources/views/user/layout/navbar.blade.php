<div class="flex justify-center items-center space-x-3 mb-12">
    <!-- Circular Image Container -->
    <div class="w-32 h-32 rounded-full bg-white shadow-lg flex items-center justify-center overflow-hidden">
        @php
            use App\Models\Setting;
            $setting = Setting::first();
            $logoPath = $setting && $setting->logo ? asset($setting->logo) : asset('uploads/logo/safalbrain.png');
        @endphp
        <img src="<?=$logoPath ?>" class="w-full h-full object-cover" />
    </div>

    <!-- Text Positioned Outside -->
    <?php
if ($setting->logo_heading) {
        ?>
    <span class="text-3xl font-bold text-blue-600"><?=$setting->logo_heading ?? '' ?></span>
    <?php
}
     ?>
</div>