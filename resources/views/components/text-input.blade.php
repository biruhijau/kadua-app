@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-[#F3F4F6] dark:bg-[#1F2937] text-black dark:text-white border-0 border-transparent rounded-lg px-4 py-3 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#C89B3C] dark:focus:ring-[#C89B3C] transition-all duration-150']) }}>