function updateEndDate() {
    const membershipSelect = document.getElementById('membership_id');
    const selectedOption = membershipSelect.options[membershipSelect.selectedIndex];
    const duration = parseInt(selectedOption.getAttribute('data-duration')); // Duration in months
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    // Ensure start date and duration are valid
    if (startDateInput.value && duration) {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(startDate);
        endDate.setMonth(startDate.getMonth() + duration); // Add duration in months

        // Handle edge cases for month overflow (e.g., adding 1 month to Jan 31 -> Feb 28/29)
        if (endDate.getDate() !== startDate.getDate()) {
            endDate.setDate(0); // Set to last day of previous month
        }

        const formattedDate = endDate.toISOString().split('T')[0]; // Format to YYYY-MM-DD
        endDateInput.value = formattedDate;
        endDateInput.readOnly = true; // Prevent manual editing
    } else {
        endDateInput.value = ''; // Clear the end date if invalid
        endDateInput.readOnly = false;
    }
}
