<?php
if (!defined('ROOT_PATH')) {
    die('Can not access');
}
$titlePage = "Btec - Create New Courses";
?>
<?php require 'view/partials/header_view.php'; ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Create a new Courses
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
        <a href="index.php?c=group&m=index" class="btn btn-primary btn-lg">Back to list</a>
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white mb-0">Create Course</h5>
            </div>
            <div class="card-body">
                <?php foreach ($group as $item) : ?>
                    <form action="index.php?c=group&m=handle-edit&id=<?= $item['groupId']; ?>" class="" method="post">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" Name="name" value="<?= $item['name'] ?>">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="">Department</label>
                                    <select name="department_id" id="" class="form-control">
                                        <option value="<?= $item['departmentId'] ?>"><?= $item['departmentName'] ?></option>
                                        <option value="">---Choose---</option>
                                        <?php foreach ($departments as $items) : ?>
                                            <option value="<?= $items['id'] ?>">
                                                <?= $items['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Term</label>
                                    <select name="term_id" id="" class="form-control">
                                        <option value="<?= $item['termID'] ?>"><?= $item['termName'] ?></option>
                                        <option value="">---Choose---</option>
                                        <?php foreach ($term as $term) : ?>
                                            <option value="<?= $term['id'] ?>">
                                                <?= $term['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="1"> Active</option>
                                        <option value="0"> Deactive</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary " name="btnUpdate" type="submit">Save</button>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Student Member</label>
                                    <input type="text" class="form-control" Name="studentMember" value="<?= $item['student_numbers'] ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Teacher</label>
                                    <input type="text" class="form-control" Name="teacher" value="<?= $item['teacher'] ?>">
                                </div>

                            </div>

                        </div>
                    <?php endforeach ?>
                    </form>
            </div>
        </div>
    </div>
</div>

<?php require 'view/partials/footer_view.php'; ?>