$("#delete-article").on("click", function (e){
    e.preventDefault();

    if(confirm('Are you sure?')){

        var frm = $("<form>");
        frm.attr('method', 'post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo("body");
        frm.submit();

    }
});

document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role_id');
    const rolePermissionsInput = document.getElementById('rolePermissions');
    const permissionsCheckboxes = document.querySelectorAll('input[type="checkbox"][name="permission[]"]');

    // Function to fetch and set permissions based on selected role
    function setRolePermissions(roleId) {
        // Fetch role permissions from the hidden input
        const rolePermissions = JSON.parse(rolePermissionsInput.value);

        // Reset all checkboxes
        permissionsCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        // Check the permissions for the selected role
        if (rolePermissions[roleId]) {
            rolePermissions[roleId].forEach(permissionId => {
                const checkbox = document.getElementById(`permission${permissionId}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }
    }

    // Event listener for role selection change
    roleSelect.addEventListener('change', function () {
        const selectedRoleId = roleSelect.value;
        setRolePermissions(selectedRoleId);
    });

    // Initial setting of permissions based on default selected role
    setRolePermissions(roleSelect.value);
});

document.addEventListener('DOMContentLoaded', function () {
    const userSelect = document.getElementById('user_id');
    const rolesRadios = document.querySelectorAll('input[type="radio"][name="role_id"]');

    // Function to set the selected role based on the user
    function setSelectedRole(userId) {
        const selectedOption = userSelect.querySelector(`option[value="${userId}"]`);
        const roleId = selectedOption.getAttribute('data-role-id');

        rolesRadios.forEach(radio => {
            radio.checked = (radio.value === roleId);
        });
    }

    // Event listener for user selection change
    userSelect.addEventListener('change', function () {
        const selectedUserId = userSelect.value;
        setSelectedRole(selectedUserId);
    });

    // Initial setting of the role based on the default selected user
    setSelectedRole(userSelect.value);
});