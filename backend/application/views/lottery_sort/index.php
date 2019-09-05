<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>
<?= lists_message() ?>
<div class="box">
    <div class="box-header">
        <form method="post" action="">
            <div class="col-xs-1" style="width:auto;">
                <label>运营商名称</label>
                <select name="operator_id" class="form-control">
                    <?php foreach ($operator as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['operator_id']) && $where['operator_id'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>玩法模式</label>
                <select name="mode" class="form-control">
                    <option value="">全部</option>
                    <?php foreach (Ettm_lottery_model::$modeList as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['mode']) && $where['mode'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>彩种类别</label>
                <select name="lottery_type_id" class="form-control">
                    <option value="">全部</option>
                    <?php foreach ($type as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['lottery_type_id']) && $where['lottery_type_id'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>彩种名称</label>
                <input type="text" name="name" class="form-control" placeholder="请输入..." value="<?= isset($where['name']) ? $where['name'] : '' ?>">
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>key_word</label>
                <input type="text" name="key_word" class="form-control" placeholder="请输入..." value="<?= isset($where['key_word']) ? $where['key_word'] : '' ?>">
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>状态</label>
                <select name="status" class="form-control">
                    <option value="">请选择</option>
                    <?php foreach (Ettm_lottery_model::$statusList as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['status']) && $where['status'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>热门</label>
                <select name="is_hot" class="form-control">
                    <option value="">请选择</option>
                    <?php foreach (Ettm_lottery_model::$is_hotList as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['is_hot']) && $where['is_hot'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>&nbsp;</label>
                <button type="submit" class="form-control btn btn-primary">查询</button>
            </div>
        </form>
    </div>
    <div class="box-header">
        <label for="per_page">显示笔数:</label>
        <input type="test" id="per_page" value="<?= $this->per_page ?>" size="1">
        <h5 class="box-title" style="font-size: 14px;"><b>总计:</b> <?= $total ?></h5>
        <?= $this->pagination->create_links() ?>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?= sort_title('default_id', '编号', $this->cur_url, $order, $where) ?></th>
                    <th width="120"><?= sort_title('mode', '玩法模式', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('lottery_type_id', '彩种类别', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('name', '彩种名称', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('key_word', 'Keyword', $this->cur_url, $order, $where) ?></th>
                    <th>图片</th>
                    <th><?= sort_title('sort', '排序', $this->cur_url, $order, $where) ?></th>
                    <th>预设状态</th>
                    <th><?= sort_title('status', '状态', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('is_hot', '是否為热门', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('hot_logo', '是否顯示HOT圖示', $this->cur_url, $order, $where) ?></th>
                    <th width="100"><?= sort_title('update_time', '修改日期', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('update_by', '最後修改者', $this->cur_url, $order, $where) ?></th>
                    <th width="80"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row['default_id'] ?></td>
                        <td><?= $row['mode_str'] ?></td>
                        <td><?= $type[$row['lottery_type_id']] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['key_word'] ?></td>
                        <td><img src="<?= $row['pic_icon'] ?>"></td>
                        <td><?= $row['sort'] ?></td>
                        <td><?= ettm_lottery_model::$statusList[$row['status_default']] ?></td>
                        <td><?= ettm_lottery_model::$statusList[$row['status']] ?></td>
                        <td><?= ettm_lottery_model::$is_hotList[$row['is_hot']] ?></td>
                        <td><?= ettm_lottery_model::$hot_logoList[$row['hot_logo']] ?></td>
                        <td><?= $row['update_time'] ?></td>
                        <td><?= $row['update_by'] ?></td>
                        <td>
                            <?php if ($this->session->userdata('roleid') == 1 || in_array("{$this->router->class}/edit", $this->allow_url)) : ?>
                                <button type="button" class="btn btn-primary" onclick="edit(<?= $row['id'] ?>)">编辑</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
        <?= $this->pagination->create_links() ?>
    </div>
</div>
<script>
    //编辑
    function edit(id) {
        layer.open({
            type: 2,
            shadeClose: false,
            title: false,
            closeBtn: [0, true],
            shade: [0.8, '#000'],
            border: [1],
            offset: ['20px', ''],
            area: ['50%', '90%'],
            content: '<?= site_url("{$this->router->class}/edit/$where[operator_id]") ?>/' + id
        });
    }
</script>