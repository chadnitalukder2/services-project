// resources/js/pages/orders-create.js

class OrderFormManager {
    constructor() {
        this.selectedServices = [];
        this.serviceCounter = 0;
        this.init();
    }

    init() {
        this.bindEvents();
        this.hideServicesTable();
    }

    bindEvents() {
        const addServiceBtn = document.getElementById('add_service');
        if (addServiceBtn) {
            addServiceBtn.addEventListener('click', () => this.handleAddService());
        }
    }

    handleAddService() {
        const serviceSelect = document.getElementById('service_select');
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

        if (selectedOption.value === '') {
            alert('Please select a service');
            return;
        }

        const serviceId = selectedOption.value;
        const serviceName = selectedOption.dataset.name;
        const servicePrice = parseFloat(selectedOption.dataset.unit_price);

        // Check if service already added
        if (this.selectedServices.find(s => s.id == serviceId)) {
            alert('This service is already added');
            return;
        }

        // Add to selected services array
        const service = {
            id: serviceId,
            name: serviceName,
            unit_price: servicePrice,
            quantity: 1,
            counter: this.serviceCounter++
        };

        this.selectedServices.push(service);
        this.addServiceToTable(service);
        this.updateTotal();
        this.showServicesTable();
        this.resetServiceSelect();
        this.updateHiddenInputs();
    }

    addServiceToTable(service) {
        const servicesTbody = document.getElementById('services_tbody');
        const row = document.createElement('tr');
        row.id = `service_row_${service.counter}`;
        
        row.innerHTML = `
            <td class="px-4 py-2 border-b">${service.name}</td>
            <td class="px-4 py-2 border-b">
                <input type="number" step="0.01" min="0" 
                       class="w-24 border-gray-300 rounded-md shadow-sm px-2 py-1 unit-price-input" 
                       data-service-counter="${service.counter}" 
                       value="${service.unit_price}" />
            </td>
            <td class="px-4 py-2 border-b">
                <input type="number" min="1" value="${service.quantity}" 
                       class="w-20 border-gray-300 rounded-md text-center quantity-input" 
                       data-service-counter="${service.counter}">
            </td>
            <td class="px-4 py-2 border-b service-total">$${(service.unit_price * service.quantity).toFixed(2)}</td>
            <td class="px-4 py-2 border-b">
                <button type="button" class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded remove-service" 
                        data-service-counter="${service.counter}">
                    Remove
                </button>
            </td>
        `;

        servicesTbody.appendChild(row);
        this.bindRowEvents(row, service.counter);
    }

    bindRowEvents(row, counter) {
        const quantityInput = row.querySelector('.quantity-input');
        const unitPriceInput = row.querySelector('.unit-price-input');
        const removeBtn = row.querySelector('.remove-service');

        quantityInput.addEventListener('input', (e) => {
            this.handleQuantityChange(counter, parseInt(e.target.value) || 1, row);
        });

        unitPriceInput.addEventListener('input', (e) => {
            this.handleUnitPriceChange(counter, parseFloat(e.target.value) || 0, row);
        });

        removeBtn.addEventListener('click', () => {
            this.removeService(counter);
        });
    }

    handleQuantityChange(counter, quantity, row) {
        const serviceIndex = this.selectedServices.findIndex(s => s.counter === counter);
        if (serviceIndex !== -1) {
            this.selectedServices[serviceIndex].quantity = quantity;
            this.updateRowTotal(row, this.selectedServices[serviceIndex]);
            this.updateTotal();
            this.updateHiddenInputs();
        }
    }

    handleUnitPriceChange(counter, unitPrice, row) {
        const serviceIndex = this.selectedServices.findIndex(s => s.counter === counter);
        if (serviceIndex !== -1) {
            this.selectedServices[serviceIndex].unit_price = unitPrice;
            this.updateRowTotal(row, this.selectedServices[serviceIndex]);
            this.updateTotal();
            this.updateHiddenInputs();
        }
    }

    updateRowTotal(row, service) {
        const serviceTotal = row.querySelector('.service-total');
        serviceTotal.textContent = `$${(service.unit_price * service.quantity).toFixed(2)}`;
    }

    removeService(counter) {
        // Remove from array
        this.selectedServices = this.selectedServices.filter(s => s.counter !== counter);

        // Remove from table
        const row = document.getElementById(`service_row_${counter}`);
        if (row) {
            row.remove();
        }

        this.updateTotal();
        this.updateHiddenInputs();

        if (this.selectedServices.length === 0) {
            this.hideServicesTable();
        }
    }

    updateTotal() {
        const total = this.selectedServices.reduce((sum, service) => {
            return sum + (service.unit_price * service.quantity);
        }, 0);

        const grandTotalElement = document.getElementById('grand_total');
        if (grandTotalElement) {
            grandTotalElement.textContent = `$${total.toFixed(2)}`;
        }
    }

    updateHiddenInputs() {
        const hiddenServicesDiv = document.getElementById('hidden_services');
        if (!hiddenServicesDiv) return;

        hiddenServicesDiv.innerHTML = '';

        // Calculate overall total amount
        const totalAmount = this.selectedServices.reduce((sum, service) => {
            return sum + (service.unit_price * service.quantity);
        }, 0);

        // Add total amount hidden input
        this.createHiddenInput('total_amount', totalAmount.toFixed(2), hiddenServicesDiv);

        // Add service-specific hidden inputs
        this.selectedServices.forEach((service, index) => {
            const subtotal = service.unit_price * service.quantity;

            this.createHiddenInput(`services[${index}][id]`, service.id, hiddenServicesDiv);
            this.createHiddenInput(`services[${index}][quantity]`, service.quantity, hiddenServicesDiv);
            this.createHiddenInput(`services[${index}][unit_price]`, service.unit_price.toFixed(2), hiddenServicesDiv);
            this.createHiddenInput(`services[${index}][subtotal]`, subtotal.toFixed(2), hiddenServicesDiv);
        });
    }

    createHiddenInput(name, value, container) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        container.appendChild(input);
    }

    showServicesTable() {
        const servicesTable = document.getElementById('services_table');
        const noServicesDiv = document.getElementById('no_services');
        
        if (servicesTable) servicesTable.style.display = 'table';
        if (noServicesDiv) noServicesDiv.style.display = 'none';
    }

    hideServicesTable() {
        const servicesTable = document.getElementById('services_table');
        const noServicesDiv = document.getElementById('no_services');
        
        if (servicesTable) servicesTable.style.display = 'none';
        if (noServicesDiv) noServicesDiv.style.display = 'block';
    }

    resetServiceSelect() {
        const serviceSelect = document.getElementById('service_select');
        if (serviceSelect) {
            serviceSelect.selectedIndex = 0;
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new OrderFormManager();
});