<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$titlePage = "Btec - Courses";
?>
<?php require 'view/partials/header_view.php'; ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Courses
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <a href="index.php?c=group&m=add" class="btn btn-primary btn-lg">Add new Group</a>
        <!-- <div class="row mt-3">
            <div class="col-sm-12 col-md-6">
                <input type="text" id="keyword" value="<?= htmlentities($keyword); ?>">
                <button class="btn btn-primary btn-sm" id="btnSearchDepartment">Search</button>
                <a href="index.php?c=department" class="btn btn-info btn-sm">Back to lists</a>
            </div>
        </div> -->
        <table class="table table-bordered table-striped my-3">
            <thead class="table-primary">
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Term</th>
                <th>Student Member</th>
                <th>Teacher</th>
                <th>Status</th>

                <th colspan="2" class="text-center" width="10%">Action</th>
            </thead>
            <tbody>
                <?php foreach ($group as $key => $item) : ?>
                    <tr>
                        <td><?= $item['groupId']; ?></td>
                        <td><?= $item['name']; ?></td>

                        <td><?= $item['departmentName']; ?></td>
                        <td><?= $item['termName']; ?></td>
                        <td><?= $item['student_numbers']; ?></td>
                        <td><?= $item['teacher']; ?></td>

                        <td><?= $item['status'] == 1 ? 'Active' : 'Deactive'; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="index.php?c=group&m=edit&id=<?= $item['groupId']; ?>">
                                Edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" href="index.php?c=group&m=delete&id=<?= $item['groupId']; ?>">
                                Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'view/partials/footer_view.php'; ?>