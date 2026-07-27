<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-6 py-3 bg-primary text-white font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-1 active:translate-y-0 transition-all duration-300 text-sm tracking-wider uppercase']) }}>
    {{ $slot }}
</button>
