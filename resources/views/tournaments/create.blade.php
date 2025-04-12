<x-app-layout>
    <x-self.base>
        <title>Crear torneo</title>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold mb-6 text-white">Crear Nuevo Torneo</h1>

            <!-- Mostrar mensaje de error de validación -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-900 text-red-400 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tournaments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 divide-y divide-gray-700">
                @csrf

                <!-- Bloque: Información del Torneo -->
                <div class="space-y-12">
                    <div class="border-b border-gray-700 pb-12">
                        <h2 class="text-base font-semibold text-white">Torneo</h2>
                        <p class="mt-1 text-sm text-gray-400">
                            This information will be displayed publicly so be careful what you share.
                        </p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- Nombre del torneo -->
                            <div class="sm:col-span-4">
                                <label for="tournament_name" class="block text-sm font-medium text-white">Nombre del torneo</label>
                                <div class="mt-2">
                                    <div class="flex items-center rounded-md bg-gray-800 outline-1 outline-gray-600 focus-within:outline-2 focus-within:outline-indigo-500">
                                        <input type="text" name="tournament_name" id="tournament_name" placeholder="Nombre del torneo..." class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none">
                                    </div>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="col-span-full">
                                <label for="description" class="block text-sm font-medium text-white">Descripción</label>
                                <div class="mt-2">
                                    <textarea name="description" id="description" rows="3" placeholder="Descripción del torneo" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500"></textarea>
                                </div>
                                <p class="mt-3 text-sm text-gray-400">Write a few sentences about the tournament.</p>
                            </div>

                            <!-- Banner del torneo (opcional) -->
                            <div class="col-span-full">
                                <label for="tournament_image" class="block text-sm font-medium text-white">Banner del torneo (opcional)</label>
                                <input type="file" name="tournament_image" id="tournament_image" accept="image/*" class="mt-2 block w-full bg-gray-800 text-white border border-gray-600 rounded-md">
                            </div>

                            <!-- Input file para el Cartel del torneo -->
                            <div class="col-span-full">
                                <label for="cartel" class="block text-sm font-medium text-white">Cartel del torneo</label>
                                <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-600 px-6 py-10">
                                    <div class="text-center">
                                        <svg class="mx-auto w-12 h-12 text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zm1.5 10.06V18c0 .414.336.75.75.75h16.5a.75.75 0 00.75-.75v-1.94l-2.69-2.69a1.5 1.5 0 00-2.12 0l-.88.88.97.97a.75.75 0 11-1.06 1.06l-5.16-5.16a1.5 1.5 0 00-2.12 0L3 16.06zM13.125 8.19a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="mt-4 flex text-sm text-gray-400">
                                            <label for="cartel" class="relative cursor-pointer rounded-md bg-gray-800 font-semibold text-indigo-400 focus-within:ring-2 focus-within:ring-indigo-400 focus-within:ring-offset-2 hover:text-indigo-300">
                                                <span>Upload a file</span>
                                                <input id="cartel" name="cartel" type="file" accept="image/*" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Información Personal -->
                    <div class="border-b border-gray-700 pb-12">
                        <h2 class="text-base font-semibold text-white">Personal Information</h2>
                        <p class="mt-1 text-sm text-gray-400">Use a permanent address where you can receive mail.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- First name -->
                            <div class="sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-white">First name</label>
                                <div class="mt-2">
                                    <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- Last name -->
                            <div class="sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium text-white">Last name</label>
                                <div class="mt-2">
                                    <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- Email address -->
                            <div class="sm:col-span-4">
                                <label for="email" class="block text-sm font-medium text-white">Email address</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-white">Country</label>
                                <div class="mt-2 grid grid-cols-1">
                                    <select id="country" name="country" autocomplete="country-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-gray-800 py-1.5 pr-8 pl-3 text-base text-white focus:outline-indigo-500 sm:text-sm">
                                        <option>United States</option>
                                        <option>Canada</option>
                                        <option>Mexico</option>
                                    </select>
                                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 w-5 h-5 self-center justify-self-end text-gray-500" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 011.06 0L8 8.94l2.72-2.72a.75.75 0 011.06 1.06l-3.25 3.25a.75.75 0 01-1.06 0L4.22 7.28a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Street address -->
                            <div class="col-span-full">
                                <label for="street-address" class="block text-sm font-medium text-white">Street address</label>
                                <div class="mt-2">
                                    <input type="text" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="sm:col-span-2 sm:col-start-1">
                                <label for="city" class="block text-sm font-medium text-white">City</label>
                                <div class="mt-2">
                                    <input type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- State / Province -->
                            <div class="sm:col-span-2">
                                <label for="region" class="block text-sm font-medium text-white">State / Province</label>
                                <div class="mt-2">
                                    <input type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- ZIP / Postal code -->
                            <div class="sm:col-span-2">
                                <label for="postal-code" class="block text-sm font-medium text-white">ZIP / Postal code</label>
                                <div class="mt-2">
                                    <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md bg-gray-800 px-3 py-1.5 text-base text-white placeholder:text-gray-400 focus:outline-none focus:outline-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Notifications -->
                    <div class="border-b border-gray-700 pb-12">
                        <h2 class="text-base font-semibold text-white">Notifications</h2>
                        <p class="mt-1 text-sm text-gray-400">We'll always let you know about important changes, but you pick what else you want to hear about.</p>

                        <div class="mt-10 space-y-10">
                            <fieldset>
                                <legend class="text-sm font-semibold text-white">By email</legend>
                                <div class="mt-6 space-y-6">
                                    <div class="flex gap-3">
                                        <div class="flex h-6 shrink-0 items-center">
                                            <div class="group grid w-4 grid-cols-1">
                                                <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" checked class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-600 bg-gray-800 checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-600 disabled:bg-gray-700">
                                                <svg class="pointer-events-none col-start-1 row-start-1 w-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                                    <path class="opacity-0 group-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path class="opacity-0 group-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="text-sm">
                                            <label for="comments" class="font-medium text-white">Comments</label>
                                            <p id="comments-description" class="text-gray-400">Get notified when someone's posts a comment on a posting.</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-6 shrink-0 items-center">
                                            <div class="group grid w-4 grid-cols-1">
                                                <input id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-600 bg-gray-800 checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-600 disabled:bg-gray-700">
                                                <svg class="pointer-events-none col-start-1 row-start-1 w-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                                    <path class="opacity-0 group-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path class="opacity-0 group-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="text-sm">
                                            <label for="candidates" class="font-medium text-white">Candidates</label>
                                            <p id="candidates-description" class="text-gray-400">Get notified when a candidate applies for a job.</p>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-6 shrink-0 items-center">
                                            <div class="group grid w-4 grid-cols-1">
                                                <input id="offers" aria-describedby="offers-description" name="offers" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-600 bg-gray-800 checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-600 disabled:bg-gray-700">
                                                <svg class="pointer-events-none col-start-1 row-start-1 w-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                                    <path class="opacity-0 group-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path class="opacity-0 group-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="text-sm">
                                            <label for="offers" class="font-medium text-white">Offers</label>
                                            <p id="offers-description" class="text-gray-400">Get notified when a candidate accepts or rejects an offer.</p>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="text-sm font-semibold text-white">Push notifications</legend>
                                <p class="mt-1 text-sm text-gray-400">These are delivered via SMS to your mobile phone.</p>
                                <div class="mt-6 space-y-6">
                                    <div class="flex items-center gap-x-3">
                                        <input id="push-everything" name="push-notifications" type="radio" checked class="relative w-4 appearance-none rounded-full border border-gray-600 bg-gray-800 before:absolute before:inset-1 before:rounded-full before:bg-gray-800 not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-600 disabled:bg-gray-700">
                                        <label for="push-everything" class="block text-sm font-medium text-white">Everything</label>
                                    </div>
                                    <div class="flex items-center gap-x-3">
                                        <input id="push-email" name="push-notifications" type="radio" class="relative w-4 appearance-none rounded-full border border-gray-600 bg-gray-800 before:absolute before:inset-1 before:rounded-full before:bg-gray-800 not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-600 disabled:bg-gray-700">
                                        <label for="push-email" class="block text-sm font-medium text-white">Same as email</label>
                                    </div>
                                    <div class="flex items-center gap-x-3">
                                        <input id="push-nothing" name="push-notifications" type="radio" class="relative w-4 appearance-none rounded-full border border-gray-600 bg-gray-800 before:absolute before:inset-1 before:rounded-full before:bg-gray-800 not-checked:before:hidden checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-600 disabled:bg-gray-700">
                                        <label for="push-nothing" class="block text-sm font-medium text-white">No push notifications</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" class="text-sm font-semibold text-gray-300">Cancel</button>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>
        </div>
    </x-self.base>
</x-app-layout>
