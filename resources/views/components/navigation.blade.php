<nav class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="flex items-center">
        <div class="shrink-0">
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="size-8" />
        </div>
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <x-nav-link href="{{ route('home') }}" route="home">Home</x-nav-link>
            <x-nav-link href="{{ route('jobs.index') }}" route="jobs.index">Jobs</x-nav-link>
            <x-nav-link href="{{ route('about') }}" route="about">About</x-nav-link>
            <x-nav-link href="{{ route('contact') }}" route="contact">Contact</x-nav-link>
          </div>
        </div>
      </div>
      <div class="hidden md:block">
        <div class="ml-4 flex items-center md:ml-6">
          <!-- Language Switcher Dropdown -->
          <el-dropdown class="relative ml-3">
            <button class="relative flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
              <span class="sr-only">{{ __('messages.language.switch_language') }}</span>
              <span>{{ app()->getLocale() === 'en' ? __('messages.language.english') : __('messages.language.chinese') }}</span>
              <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="ml-1 size-4">
                <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
            </button>

            <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
              <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden {{ app()->getLocale() === 'en' ? 'bg-gray-50 font-medium' : '' }}">
                {{ __('messages.language.english') }}
              </a>
              <a href="{{ route('locale.switch', 'zh_TW') }}" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden {{ app()->getLocale() === 'zh_TW' ? 'bg-gray-50 font-medium' : '' }}">
                {{ __('messages.language.chinese') }}
              </a>
            </el-menu>
          </el-dropdown>

          @auth
            <button type="button" class="relative ml-3 rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
              <span class="absolute -inset-1.5"></span>
              <span class="sr-only">View notifications</span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <el-dropdown class="relative ml-3">
              <button class="relative flex max-w-xs items-center rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Open user menu</span>
                <div class="flex size-8 items-center justify-center rounded-full bg-indigo-500 text-sm font-medium text-white outline -outline-offset-1 outline-white/10">
                  {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
              </button>

              <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-white py-1 shadow-lg outline-1 outline-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden">Your profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 focus:bg-gray-100 focus:outline-hidden">
                    Sign out
                  </button>
                </form>
              </el-menu>
            </el-dropdown>
          @else
            <a href="{{ route('register') }}" class="ml-3 rounded-md px-3 py-2 text-sm font-semibold text-gray-300 hover:bg-white/5 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
              Register
            </a>
            <a href="{{ route('login') }}" class="ml-3 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              Sign in
            </a>
          @endauth
        </div>
      </div>
      <div class="-mr-2 flex md:hidden">
        <!-- Mobile menu button -->
        <button type="button" command="--toggle" commandfor="mobile-menu" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
            <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <el-disclosure id="mobile-menu" hidden class="block md:hidden">
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
      <x-nav-link href="{{ route('home') }}" route="home" class="block text-base">Home</x-nav-link>
      <x-nav-link href="{{ route('jobs.index') }}" route="jobs.index" class="block text-base">Jobs</x-nav-link>
      <x-nav-link href="{{ route('about') }}" route="about" class="block text-base">About</x-nav-link>
      <x-nav-link href="{{ route('contact') }}" route="contact" class="block text-base">Contact</x-nav-link>
      <div class="border-t border-white/10 pt-2">
        <button type="button" command="--toggle" commandfor="language-menu" class="flex w-full items-center justify-between rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
          <span>{{ __('messages.language.switch_language') }}</span>
          <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-4">
            <path d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
          </svg>
        </button>
        <el-disclosure id="language-menu" hidden class="overflow-hidden transition transition-discrete data-closed:max-h-0 data-enter:max-h-96">
          <div class="px-2 space-y-1 pt-1">
            <a href="{{ route('locale.switch', 'en') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white {{ app()->getLocale() === 'en' ? 'bg-white/5 text-white' : '' }}">
              {{ __('messages.language.english') }}
            </a>
            <a href="{{ route('locale.switch', 'zh_TW') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white {{ app()->getLocale() === 'zh_TW' ? 'bg-white/5 text-white' : '' }}">
              {{ __('messages.language.chinese') }}
            </a>
          </div>
        </el-disclosure>
      </div>
    </div>
    @auth
      <div class="border-t border-white/10 pt-4 pb-3">
        <div class="flex items-center px-5">
          <div class="shrink-0">
            <div class="flex size-10 items-center justify-center rounded-full bg-indigo-500 text-base font-medium text-white outline -outline-offset-1 outline-white/10">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
          </div>
          <div class="ml-3">
            <div class="text-base/5 font-medium text-white">{{ Auth::user()->name }}</div>
            <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
          </div>
          <button type="button" class="relative ml-auto shrink-0 rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">View notifications</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
              <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <div class="mt-3 space-y-1 px-2">
          <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Your profile</a>
          <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">Settings</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full rounded-md px-3 py-2 text-left text-base font-medium text-gray-400 hover:bg-white/5 hover:text-white">
              Sign out
            </button>
          </form>
        </div>
      </div>
    @else
      <div class="border-t border-white/10 pt-4 pb-3">
        <div class="px-2 space-y-2">
          <a href="{{ route('register') }}" class="block rounded-md px-3 py-2 text-center text-base font-semibold text-gray-300 hover:bg-white/5 hover:text-white">
            Register
          </a>
          <a href="{{ route('login') }}" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-base font-semibold text-white shadow-sm hover:bg-indigo-500">
            Sign in
          </a>
        </div>
      </div>
    @endauth
  </el-disclosure>
</nav>

