@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card registration-card">
                <div class="card-header custom-card-header text-center">
                    {{ __('Visitor Registration') }}
                </div>

                <div class="card-body">
                    <!-- Alert Message Container -->
                    <div id="alertMessage" class="hidden"></div>

                    <form id="rfidRegistrationForm" method="POST" action="{{ route('visitor.register') }}" class="row g-3">
                        @csrf

                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- MyKad Section -->
                            <div class="mykad-section mb-4">
                                <h5 class="section-title"><i class="fas fa-id-card me-2"></i> MyKad Information</h5>

                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="name_printed" class="form-label">Name:</label>
                                        <input type="text" id="name_printed" name="name_printed" class="form-control" readonly required>
                                    </div>

                                    <div class="col-12">
                                        <label for="ic_number" class="form-label">IC Number:</label>
                                        <input type="text" id="ic_number" name="ic_number" class="form-control" readonly required>
                                    </div>

                                    <div class="col-12">
                                        <label for="address_1" class="form-label">Address:</label>
                                        <input type="text" id="address_1" name="address_1" class="form-control" readonly required>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <button type="button" id="readCardBtn" class="btn btn-success w-100 mykad-btn">
                                            <i class="fas fa-id-card me-2"></i>Read MyKad
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Visitor Information -->
                            <div class="visitor-info mb-4">
                                <h5 class="section-title"><i class="fas fa-user me-2"></i> Visitor Information</h5>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label for="visitor_type" class="form-label">Visitor Type:</label>
                                        <select id="visitor_type" name="visitor_type" class="form-select" required>
                                            <option value="occasional">Occasional Visitor</option>
                                            <option value="technician">Technician</option>
                                            <option value="food delivery guy">Food Delivery Guy</option>
                                            <option value="parcel delivery guy">Parcel Delivery Guy</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="house_number" class="form-label">House Number:</label>
                                        <input type="text" id="house_number" name="house_number" class="form-control" placeholder="Enter House Number" required>
                                    </div>

                                    <div class="col-12">
                                        <label for="vehicle_plate" class="form-label">Vehicle Plate (Optional):</label>
                                        <input type="text" id="vehicle_plate" name="vehicle_plate" class="form-control" placeholder="e.g., ABC1234">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- RFID Section -->
                            <div class="rfid-section mb-4">
                                <h5 class="section-title"><i class="fas fa-tag me-2"></i> RFID Assignment</h5>

                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="rfid_sticker" class="form-label">Select RFID:</label>
                                        <select id="rfid_sticker" name="rfid_id" class="form-select" required>
                                            <option value="">Loading RFIDs...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <label for="rfid_type" class="form-label">RFID Type:</label>
                                <select id="rfid_type" name="type" class="form-select" required>
                                    <option value="reusable" selected>Reusable</option>
                                    <option value="permanent">Permanent</option>
                                </select>
                            </div>

                            <!-- Visit Details -->
                            <div class="visit-details mb-4">
                                <h5 class="section-title"><i class="fas fa-calendar-alt me-2"></i> Visit Details</h5>

                                <div class="row g-2">
                                    <input type="hidden" id="valid_from" name="valid_from">
                                    <div class="col-md-6">
                                        <label for="valid_until" class="form-label">Check-out Time:</label>
                                        <input type="datetime-local" id="valid_until" name="valid_until" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="submit-section mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-save me-2"></i>Submit Registration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="confirmModalLabel"><i class="fas fa-user-check me-2"></i> Confirm Registration</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Please confirm the following details before submission:</p>
        <ul class="list-group">
          <li class="list-group-item"><strong>Name:</strong> <span id="confirm_name"></span></li>
          <li class="list-group-item"><strong>IC Number:</strong> <span id="confirm_ic"></span></li>
          <li class="list-group-item"><strong>Address:</strong> <span id="confirm_address"></span></li>
          <li class="list-group-item"><strong>House Number:</strong> <span id="confirm_house"></span></li>
          <li class="list-group-item"><strong>Visitor Type:</strong> <span id="confirm_type"></span></li>
          <li class="list-group-item"><strong>RFID Sticker:</strong> <span id="confirm_rfid"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmSubmitBtn" class="btn btn-primary">Confirm & Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Minimal style tag for dynamic classes -->
<style>
    .hidden {
        display: none !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    init();

    async function init() {
        setValidTimeFields();
        await loadInactiveRfids();
        bindEvents();
    }

    function setValidTimeFields() {
        const now = new Date();
        document.getElementById('valid_from').value = now.toISOString().slice(0, 16);

        const later = new Date();
        later.setHours(now.getHours() + 2);
        document.getElementById('valid_until').value = later.toISOString().slice(0, 16);
    }

    function bindEvents() {
        document.getElementById('readCardBtn').addEventListener('click', readMyKad);
        document.getElementById('rfid_sticker').addEventListener('change', syncRfidType);
        document.getElementById('rfidRegistrationForm').addEventListener('submit', handleFormSubmit);
        document.getElementById('confirmSubmitBtn').addEventListener('click', submitFinalForm);
    }

    function toggleButtonLoading(button, isLoading, text) {
        button.disabled = isLoading;
        button.innerHTML = isLoading ? `<span class="spinner-border spinner-border-sm"></span> ${text}` : text;
    }

    async function loadInactiveRfids() {
        const dropdown = document.getElementById('rfid_sticker');
        try {
            const response = await fetch('/api/inactive-rfids');
            const data = await response.json();

            dropdown.innerHTML = '<option value="">Select RFID</option>';
            if (data.status === 'success' && data.rfids?.length) {
                data.rfids.forEach(rfid => {
                    const option = new Option(`Sticker #${rfid.id} (${rfid.rfid_string}) [${rfid.type}]`, rfid.id);
                    dropdown.appendChild(option);
                });
            } else {
                dropdown.innerHTML = '<option value="" disabled>No available RFIDs</option>';
            }
        } catch (error) {
            console.error(error);
            dropdown.innerHTML = '<option value="" disabled>Error loading RFIDs</option>';
            showPopup('Failed to load RFID list', 'error');
        }
    }

    async function readMyKad() {
        const button = document.getElementById('readCardBtn');
        toggleButtonLoading(button, true, 'Reading...');
        try {
            const response = await fetch('/mykad-direct-proxy');
            const data = await response.json();

            if (!data) throw new Error('No card detected');

            document.getElementById('name_printed').value = data.name_1 || '';
            document.getElementById('ic_number').value = data.ic_number || '';

            const fullAddress = [
                data.address_1, data.address_2, data.address_3, data.city,
                `${data.state} ${data.post_code}`
            ].filter(Boolean).join(', ');

            document.getElementById('address_1').value = fullAddress;

            showPopup('MyKad read successfully!');
        } catch (error) {
            console.error(error);
            showPopup(error.message, 'error');
        } finally {
            toggleButtonLoading(button, false, '<i class="fas fa-id-card me-2"></i>Read MyKad');
        }
    }

    function syncRfidType() {
        const selected = this.options[this.selectedIndex];
        const match = selected.textContent.match(/\[(reusable|permanent)\]/i);
        document.getElementById('rfid_type').value = match?.[1]?.toLowerCase() || 'reusable';
    }

    function populateConfirmationModal() {
        document.getElementById('confirm_name').textContent = document.getElementById('name_printed').value;
        document.getElementById('confirm_ic').textContent = document.getElementById('ic_number').value;
        document.getElementById('confirm_address').textContent = document.getElementById('address_1').value;
        document.getElementById('confirm_house').textContent = document.getElementById('house_number').value;
        document.getElementById('confirm_type').textContent = document.getElementById('visitor_type').value;
        const rfidText = document.getElementById('rfid_sticker').selectedOptions[0]?.textContent || '';
        document.getElementById('confirm_rfid').textContent = rfidText;
    }

    function handleFormSubmit(e) {
        e.preventDefault();

        const form = e.target;
        const name = document.getElementById('name_printed').value;
        const ic = document.getElementById('ic_number').value;
        const address = document.getElementById('address_1').value;
        const rfid = document.getElementById('rfid_sticker').value;

        if (!name || !ic || !address) return showPopup('Please read your MyKad first', 'error');
        if (!rfid) return showPopup('Please select an RFID sticker', 'error');

        populateConfirmationModal();
        new bootstrap.Modal(document.getElementById('confirmModal')).show();
    }

    async function submitFinalForm() {
        const form = document.getElementById('rfidRegistrationForm');
        const submitBtn = form.querySelector('button[type="submit"]');

        toggleButtonLoading(submitBtn, true, 'Processing...');

        try {
            const formData = new FormData(form);
            const response = await fetch('/rfid-registration', {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Submission failed');

            if (data.status === 'success') {
                showPopup(data.message);
                form.reset();
                loadInactiveRfids();
                document.getElementById('rfid_type').value = 'reusable';
                bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
            } else {
                throw new Error(data.message || 'An error occurred');
            }
        } catch (error) {
            console.error(error);
            showPopup(error.message, 'error');
        } finally {
            toggleButtonLoading(submitBtn, false, '<i class="fas fa-save me-2"></i>Submit Registration');
        }
    }

    function showPopup(message, type = 'success') {
        const alertBox = document.getElementById('alertMessage');
        alertBox.className = `alert alert-${type === 'error' ? 'danger' : 'success'}`;
        alertBox.textContent = message;
        alertBox.classList.remove('hidden');
        setTimeout(() => alertBox.classList.add('hidden'), 5000);
    }
});
</script>

@endsection
