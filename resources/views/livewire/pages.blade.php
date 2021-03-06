<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-jet-button>
    </div>

    {{-- The data table --}}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-center text-base leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-base leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Link') }}</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-base leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Robots') }}</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-base leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-base leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Content') }}</th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-base leading-4 font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @if ($data->count())
                            @foreach ($data as $item)
                                <tr>
                                    <td class="px-6 py-2 text-center">
                                        {{ $item->title }}
                                        {!! $item->is_default_home ? '<span class="text-green-400 text-xs font-bold">[Default Home Page]</span>':'' !!}
                                        {!! $item->is_default_not_found ? '<span class="text-red-400 text-xs font-bold">[Default 404 Page]</span>':'' !!}
                                    </td>
                                    <td class="px-6 py-2 text-center">
                                        <a
                                            class="text-indigo-600 hover:text-indigo-900"
                                            target="_blank"
                                            href="{{ URL::to('/'.$item->slug) }}"
                                        >
                                            {{ $item->slug }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-2 text-center">{{ $item->robots }}</td>
                                    <td class="px-6 py-2 text-center">{{ $item->status }}</td>
                                    <td class="ppx-6 py-2 text-center">{!! \Illuminate\Support\Str::limit($item->content, 50, '...') !!}</td>
                                    <td class="px-6 py-2 flex justify-end text-center">
                                        <x-jet-button wire:click="updateShowModal({{ $item->id }})">
                                            {{ __('Update') }}
                                        </x-jet-button>
                                        <x-jet-danger-button class="ml-2" wire:click="deleteShowModal({{ $item->id }})">
                                            {{ __('Delete') }}
                                        </x-jet-danger-button>
                                    </td>
                                </tr>
                            @endforeach
                        @else

                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <br/>
    {{ $data->links() }}

    {{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save Page') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Title') }}"></x-jet-label>
                <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="title"></x-jet-input>
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="keywords" value="{{ __('Meta keywords (only if robots is index)') }}"></x-jet-label>
                <x-jet-input id="keywords" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="keywords"></x-jet-input>
                @error('keywords') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="description" value="{{ __('Meta Description (only if robots is index)') }}"></x-jet-label>
                <x-jet-input id="description" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="description"></x-jet-input>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="robots" value="{{ __('Meta Robots') }}"></x-jet-label>
                <label>
                    <select wire:model="robots" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="NoIndex-NoFollow">Noindex, Nofollow</option>
                        <option value="Index-Follow">Index, Follow</option>
                        <option value="NoIndex-Follow">Noindex, Follow</option>
                        <option value="Index-NoFollow">Index, Nofollow</option>
                    </select>
                </label>
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Slug') }}"></x-jet-label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-1-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-base">
                        http://localhost:8000/
                    </span>
                    <x-jet-input wire:model="slug" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-base sm:leading-5" placeholder="url-slug"></x-jet-input>
                </div>
                @error('slug') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <label>
                    <input class="form-checkbox" type="checkbox" value="{{ $isSetToDefaultHomePage }}" wire:model="isSetToDefaultHomePage">
                    <span class="ml-2 text-sm text-gray-600">Set as the default home page</span>
                </label>
            </div>
            <div class="mt-4">
                <label>
                    <input class="form-checkbox" type="checkbox" value="{{ $isSetToDefaultNotFoundPage }}" wire:model="isSetToDefaultNotFoundPage">
                    <span class="ml-2 text-sm text-red-600">Set as the default 404 error page</span>
                </label>
            </div>
            <div class="mt-4">
                <x-jet-label for="status" value="{{ __('Status') }}"></x-jet-label>
                <label>
                    <select wire:model="status" class="block appearance-none w-full bg-gray-100 border border-gray-200 text-gray-700 py-3 px-4 pr-8 round leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="Disabled">Disabled</option>
                        <option value="Activated">Activated</option>
                    </select>
                </label>
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('Content') }}"></x-jet-label>
                <div class="rounded-md shadow-sm">
                    <div class="mt-1 bg-white">
                        <div class="body-content" wire:ignore>
                            <trix-editor
                                class="trix-content"
                                x-ref="trix"
                                wire:model.debounce.100000ms="content"
                                wire:key="trix-content-unique-key"
                            ></trix-editor>
                        </div>
                    </div>
                </div>
                @error('content') <span class="error">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-danger-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-danger-button>
            @else
                <x-jet-danger-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-danger-button>
            @endif

        </x-slot>
    </x-jet-dialog-modal>

    {{-- The Delete Modal --}}

    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Page') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this page? Once this page is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Page') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
