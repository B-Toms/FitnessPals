<nav class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="font-bold text-xl text-emerald-600 tracking-wide">
                        FitnessPals
                    </a>
                </div>

                <div class="flex space-x-8 sm:-my-px sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Sākums') }}
                    </x-nav-link>

                    @if(Auth::user()->isCoach())
                        <x-nav-link :href="route('coach.dashboard')" :active="request()->routeIs('coach.dashboard')">
                            {{ __('Trenera panelis') }}
                        </x-nav-link>
                    @endif
                    @auth
                        <x-nav-link :href="route('client.bookings.index')" :active="request()->routeIs('client.bookings.index')">
                            {{ __('Manas rezervācijas') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="flex sm:items-center sm:ms-6 gap-4">
                
                <div class="flex items-center gap-1 bg-gray-50 border border-gray-200 p-1  text-xs font-bold">
                    <a href="?lang=lv" class="px-2.5 py-1  transition {{ app()->getLocale() == 'lv' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        LV
                    </a>
                    <a href="?lang=en" class="px-2.5 py-1  transition {{ app()->getLocale() == 'en' ? 'bg-emerald-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        EN
                    </a>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->Vārds ?? Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profils') }}
                        </x-dropdown-link>

                        @if(Auth::user()->isCoach())
                            <x-dropdown-link :href="route('coach.profile.edit')">
                                {{ __('Labot trenera info') }}
                            </x-dropdown-link>
                        @endif
                        {{-- END JAUNĀ DAĻA --}}

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Izrakstīties') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>