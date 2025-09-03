<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:from-indigo-700 focus:to-purple-700 active:from-indigo-800 active:to-purple-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 hover:shadow-lg']) }}>
    {{ $slot }}
</button>
