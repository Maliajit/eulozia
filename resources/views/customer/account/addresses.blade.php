@extends('customer.layouts.master')

@section('title', 'My Addresses - Fashion Store')

@section('content')
    <div class="account-container max-w-7xl mx-auto px-4 py-8 mt-16">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Saved Addresses</h1>
                <p class="text-gray-300">Manage your shipping and billing addresses for faster checkout.</p>
            </div>
            <button onclick="openAddressModal()"
                class="bg-white text-black px-6 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                <i class="fas fa-plus mr-2"></i> Add New Address
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($addresses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($addresses as $address)
                    <div class="address-card bg-black border border-gray-800 rounded-lg p-6 relative group">
                        @if($address->is_default)
                            <span
                                class="absolute top-4 right-4 bg-white text-black text-[10px] font-bold px-2 py-1 rounded-full uppercase">Default</span>
                        @endif

                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center mr-3">
                                <i
                                    class="fas fa-{{ $address->type == 'shipping' ? 'truck' : ($address->type == 'billing' ? 'file-invoice-dollar' : 'map-marker-alt') }} text-gray-400"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-bold">{{ $address->name }}</h4>
                                <span
                                    class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ $address->type }}</span>
                            </div>
                        </div>

                        <div class="space-y-1 mb-6">
                            <p class="text-gray-400 text-sm">{{ $address->address }}</p>
                            <p class="text-gray-400 text-sm">{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}</p>
                            <p class="text-gray-400 text-sm">{{ $address->country }}</p>
                            <p class="text-gray-400 text-sm mt-2"><i class="fas fa-phone mr-1 text-gray-600"></i>
                                {{ $address->mobile }}</p>
                        </div>

                        <div class="flex items-center gap-4 pt-4 border-t border-gray-900">
                            <button onclick="editAddress({{ json_encode($address) }})"
                                class="text-gray-400 hover:text-white text-sm font-medium transition-colors">Edit</button>

                            <form action="{{ route('customer.account.addresses.delete', $address->id) }}" method="POST"
                                class="inline" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">Delete</button>
                            </form>

                            @if(!$address->is_default)
                                <form action="{{ route('customer.account.addresses.set-default', $address->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="text-accent hover:text-white text-sm font-medium transition-colors ml-auto">Set
                                        Default</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-black border border-gray-800 rounded-lg p-12 text-center mt-8">
                <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-map-marker-alt text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No addresses saved yet</h3>
                <p class="text-gray-400 mb-8 max-w-md mx-auto">Add your shipping and billing addresses to make your checkout
                    process faster and easier.</p>
                <button onclick="openAddressModal()"
                    class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                    Add Your First Address
                </button>
            </div>
        @endif
    </div>

    <!-- Address Modal -->
    <div id="addressModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-800 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center sticky top-0 bg-gray-900 z-10">
                <h2 id="modalTitle" class="text-2xl font-bold text-white">Add New Address</h2>
                <button onclick="closeAddressModal()" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form id="addressForm" method="POST" action="{{ route('customer.account.addresses.store') }}"
                class="p-6 space-y-6">
                @csrf
                <div id="methodField"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                        <input type="text" name="name" id="address_name" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Mobile Number</label>
                        <input type="text" name="mobile" id="address_mobile" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);" inputmode="numeric"
                            maxlength="10" minlength="10">
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Address Type</label>
                        <select name="type" id="address_type" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                            <option value="shipping">Shipping</option>
                            <option value="billing">Billing</option>
                            <option value="both">Both</option>
                        </select>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Full Address</label>
                        <textarea name="address" id="address_text" rows="3" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-400 mb-2">City</label>
                        <input type="text" name="city" id="address_city" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-400 mb-2">State</label>
                        <input type="text" name="state" id="address_state" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Pincode</label>
                        <input type="text" name="pincode" id="address_pincode" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);" inputmode="numeric"
                            maxlength="6" minlength="6">
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Country</label>
                        <input type="text" name="country" id="address_country" value="IN" maxlength="2" required
                            class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_default" id="address_is_default" value="1"
                        class="w-4 h-4 bg-black border-gray-800 rounded text-white focus:ring-0">
                    <label for="address_is_default" class="ml-2 text-sm text-gray-400">Set as default address</label>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-gray-800">
                    <button type="button" onclick="closeAddressModal()"
                        class="px-6 py-3 rounded-lg text-white hover:bg-gray-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                        Save Address
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const modal = document.getElementById('addressModal');
            const form = document.getElementById('addressForm');
            const title = document.getElementById('modalTitle');
            const methodField = document.getElementById('methodField');
            const storeUrl = "{{ route('customer.account.addresses.store') }}";

            function openAddressModal() {
                title.innerText = 'Add New Address';
                form.action = storeUrl;
                methodField.innerHTML = '';
                form.reset();
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeAddressModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function editAddress(address) {
                title.innerText = 'Edit Address';
                form.action = `/account/addresses/${address.id}`;
                methodField.innerHTML = '@method("PUT")';

                document.getElementById('address_name').value = address.name;
                document.getElementById('address_mobile').value = address.mobile;
                document.getElementById('address_type').value = address.type;
                document.getElementById('address_text').value = address.address;
                document.getElementById('address_city').value = address.city;
                document.getElementById('address_state').value = address.state;
                document.getElementById('address_pincode').value = address.pincode;
                document.getElementById('address_country').value = address.country;
                document.getElementById('address_is_default').checked = address.is_default;

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            // Close modal on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeAddressModal();
            });
        </script>
    @endpush
@endsection