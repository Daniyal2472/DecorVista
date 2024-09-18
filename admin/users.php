<?php
include 'header.php';

// Check if there's an error or success message in the session
if (isset($_SESSION['message'])) {
    echo '<script>alert("' . $_SESSION['message'] . '");</script>';
    unset($_SESSION['message']);
} elseif (isset($_SESSION['error'])) {
    echo '<script>alert("' . $_SESSION['error'] . '");</script>';
    unset($_SESSION['error']);
}

// SQL query to fetch all users
$sql = "SELECT * FROM users";

// Execute the query
$result = $con->query($sql);

?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">DataTables.Net</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Tables</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Datatables</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add Row</h4>
                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addRowModal">
                                <i class="fa fa-plus"></i>
                                Add User
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Modal -->
                        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold"> New</span>
                                            <span class="fw-light"> User </span>
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="small">Create a new user using this form, make sure you fill them all</p>
                                        <form id="addUserForm" action="add_user.php" method="POST" onsubmit="return validateAddUser()">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Username</label>
                                                        <input id="addName" name="username" type="text" class="form-control" placeholder="Enter username" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pe-0">
                                                    <div class="form-group form-group-default">
                                                        <label>Email</label>
                                                        <input id="addEmail" name="email" type="email" class="form-control" placeholder="Enter email" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Contact</label>
                                                        <input id="addContact" name="contact" type="text" class="form-control" placeholder="Enter contact number" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Password</label>
                                                        <input id="addPassword" name="password" type="password" class="form-control" placeholder="Enter password" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Role</label>
                                                        <select name="role" class="form-control" required>
                                                            <option value="homeowner">Homeowner</option>
                                                            <option value="designer">Designer</option>
                                                            <option value="admin">Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary">Add</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                        <script>
                                            function validateContact(contact) {
                                                const contactRegex = /^[0-9]{10,15}$/; // Allow contact numbers of 10 to 15 digits
                                                return contactRegex.test(contact);
                                            }

                                            function validateAddUser() {
                                                var username = document.getElementById("addName").value;
                                                var email = document.getElementById("addEmail").value;
                                                var password = document.getElementById("addPassword").value;
                                                var contact = document.getElementById("addContact").value;

                                                if (username == "") {
                                                    alert("Username is required");
                                                    return false;
                                                }
                                                if (!validateEmail(email)) {
                                                    alert("Please enter a valid email address");
                                                    return false;
                                                }
                                                if (!validateContact(contact)) {
                                                    alert("Please enter a valid contact number (10-15 digits)");
                                                    return false;
                                                }
                                                if (password.length < 6) {
                                                    alert("Password must be at least 6 characters long");
                                                    return false;
                                                }
                                                return true;
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">
                                            <span class="fw-mediumbold"> Edit</span>
                                            <span class="fw-light"> User </span>
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="small">Edit the details of this user.</p>
                                        <form id="editUserForm" action="edit_user.php" method="POST" onsubmit="return validateEditUser()">
                                            <input type="hidden" id="editUserId" name="user_id">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Username</label>
                                                        <input id="editUsername" name="username" type="text" class="form-control" placeholder="Enter username" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6 pe-0">
                                                    <div class="form-group form-group-default">
                                                        <label>Email</label>
                                                        <input id="editEmail" name="email" type="email" class="form-control" placeholder="Enter email" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Contact</label>
                                                        <input id="editContact" name="contact" type="text" class="form-control" placeholder="Enter contact number" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Password</label>
                                                        <input id="editPassword" name="password" type="password" class="form-control" placeholder="Leave blank to keep current password" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group form-group-default">
                                                        <label>Role</label>
                                                        <select id="editRole" name="role" class="form-control" required>
                                                            <option value="homeowner">Homeowner</option>
                                                            <option value="designer">Designer</option>
                                                            <option value="admin">Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                        <script>
                                            function validateEditUser() {
                                                var username = document.getElementById("editUsername").value;
                                                var email = document.getElementById("editEmail").value;
                                                var password = document.getElementById("editPassword").value;

                                                if (username == "") {
                                                    alert("Username is required");
                                                    return false;
                                                }
                                                if (!validateEmail(email)) {
                                                    alert("Please enter a valid email address");
                                                    return false;
                                                }
                                                if (password && password.length < 6) {
                                                    alert("Password must be at least 6 characters long");
                                                    return false;
                                                }
                                                return true;
                                            }

                                            function validateContact(contact) {
                                                const contactRegex = /^[0-9]{10,15}$/; // Allow contact numbers of 10 to 15 digits
                                                return contactRegex.test(contact);
                                            }

                                            function validateForm() {
                                                const contact = document.getElementById("addContact").value;

                                                if (!validateContact(contact)) {
                                                    alert("Please enter a valid contact number (10-15 digits).");
                                                    return false;
                                                }
                                                return true;
                                            }

                                            document.querySelector("form[action='add_user.php']").onsubmit = function () {
                                                return validateForm();
                                            };
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Role</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Contact</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // Check if there are any records
                                    if ($result->num_rows > 0) {
                                        // Output data for each row
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row["username"]; ?></td>
                                                <td><?php echo $row["email"]; ?></td>
                                                <td><?php echo $row["contact"]; ?></td>
                                                <td><?php echo $row["role"]; ?></td>
                                                <td>
                                                    <div class="form-button-action">
                                                        <button type="button" data-bs-toggle="tooltip" title="Edit" class="btn btn-link btn-primary btn-lg" onclick="editUser('<?php echo $row['user_id']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['contact']; ?>', '<?php echo $row['role']; ?>')">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                        <!-- Update the form for deleting a user -->
                                                        <form action="delete_user.php" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                            <button type="submit" class="btn btn-link btn-danger" data-original-title="Remove">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "0 results";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        var column = this;
                        var select = $('<select class="form-select"><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append('<option value="' + d + '">' + d + "</option>");
                            });
                    });
            },
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 5,
        });

        var action = '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function() {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });
    });
</script>
<script>
    function confirmDelete() {
        console.log('Confirm delete triggered');
        return confirm('Are you sure you want to delete this user?');
    }
</script>
<script>
    function editUser(userId, username, email, contact, role) {
        // Set values in the modal
        document.getElementById('editUserId').value = userId;
        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;
        document.getElementById('editContact').value = contact;  // Correctly setting the contact value here
        document.getElementById('editRole').value = role;

        // Show the modal
        $('#editRowModal').modal('show');
    }
</script>

<?php 
include 'footer.php';
?>
