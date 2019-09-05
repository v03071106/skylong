<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>
<?= lists_message() ?>
<div class="box">
    <div class="box-header">
        <form method="post" action="">
            <div class="col-xs-1" style="width:auto;">
                <label>运营商名称</label>
                <select name="operator_id" class="form-control">
                    <option value="">全部</option>
                    <?php foreach ($operator as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['operator_id']) && $where['operator_id'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>应用类型</label>
                <select name="type" class="form-control">
                    <option value="">全部</option>
                    <?php foreach (apps_model::$typeList as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['type']) && $where['type'] == $key ? 'selected' : '' ?>><?= $val ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>应用名稱</label>
                <input type="text" name="name" class="form-control" placeholder="请输入..." value="<?= isset($where['name']) ? $where['name'] : '' ?>">
            </div>
            <div class="col-xs-1" style="width:auto;">
                <label>VIP包</label>
                <select name="is_vip" class="form-control">
                    <option value="">全部</option>
                    <?php foreach (apps_model::$is_vipList as $key => $val) : ?>
                        <option value="<?= $key ?>" <?= isset($where['is_vip']) && $where['is_vip'] == $key ? 'selected' : '' ?>><?= $val ?></option>
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
                    <th nowrap><?= sort_title('id', '编号', $this->cur_url, $order, $where) ?></th>
                    <th nowrap><?= sort_title('operator_id', '运营商名称', $this->cur_url, $order, $where) ?></th>
                    <th nowrap><?= sort_title('type', '应用类型', $this->cur_url, $order, $where) ?></th>
                    <th nowrap><?= sort_title('name', '应用名稱', $this->cur_url, $order, $where) ?></th>
                    <th width="250"><?= sort_title('jump_url', '跳转URL(H5网页地址)', $this->cur_url, $order, $where) ?></th>
                    <th width="250"><?= sort_title('download_url', '下载URL', $this->cur_url, $order, $where) ?></th>
                    <th>二维码</th>
                    <th nowrap><?= sort_title('downloads', '下载次数', $this->cur_url, $order, $where) ?></th>
                    <th><?= sort_title('status', '状态', $this->cur_url, $order, $where) ?></th>
                    <th width="90"><?= sort_title('update_time', '修改时间', $this->cur_url, $order, $where) ?></th>
                    <th nowrap><?= sort_title('update_by', '更新者', $this->cur_url, $order, $where) ?></th>
                    <th width="140">
                        <?php if ($this->session->userdata('roleid') == 1 || in_array("{$this->router->class}/create", $this->allow_url)) : ?>
                            <button type="button" class="btn btn-primary" onclick="add(0)">添加</button>
                        <?php endif; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $operator[$row['operator_id']] ?></td>
                        <td><?= apps_model::$typeList[$row['type']] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td style="word-break: break-all;"><?= $row['jump_url'] ?></td>
                        <td style="word-break: break-all;"><?= $row['download_url'] ?></td>
                        <td>
                            <div id="qrcode_<?= $row['id'] ?>" class="qrcode" url="<?= $row['download_url'] ?>"></div>
                        </td>
                        <td><?= $row['downloads'] ?></td>
                        <td>
                            <?php if ($this->session->userdata('roleid') == 1 || in_array("{$this->router->class}/edit", $this->allow_url)) : ?>
                                <button type="button" id="status1_<?= $row['id'] ?>" class="btn <?= $row['status'] == 1 ? 'btn-info' : 'btn-default' ?>" onclick="status_row(<?= $row['id'] ?>,1)"><?= apps_model::$statusList[1] ?></button>
                                <button type="button" id="status0_<?= $row['id'] ?>" class="btn <?= $row['status'] == 0 ? '' : 'btn-default' ?>" onclick="status_row(<?= $row['id'] ?>,0)"><?= apps_model::$statusList[0] ?></button>
                            <?php else : ?>
                                <?= apps_model::$statusList[$row['status']] ?>
                            <?php endif; ?>
                        </td>
                        <td><?= $row['update_time'] ?></td>
                        <td><?= $row['update_by'] ?></td>
                        <td>
                            <?php if ($this->session->userdata('roleid') == 1 || in_array("{$this->router->class}/create", $this->allow_url)) : ?>
                                <button type="button" class="btn btn-primary" style="margin-bottom: 3px;" onclick="add(<?= $row['id'] ?>)">复制新增</button>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('roleid') == 1 || in_array("{$this->router->class}/edit", $this->allow_url)) : ?>
                                <button type="button" class="btn btn-primary" onclick="edit(<?= $row['id'] ?>)">编辑</button>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('roleid') == 1 || in_array("{$this->router->class}/delete", $this->allow_url)) : ?>
                                <button type="button" class="btn btn-primary" onclick="delete_row(<?= $row['id'] ?>)">删除</button>
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
<script src="<?= base_url('static/dist/js/qrcode.min.js') ?>"></script>
<script>
    //添加
    function add(id) {
        layer.open({
            type: 2,
            shadeClose: false,
            title: false,
            closeBtn: [0, true],
            shade: [0.8, '#000'],
            border: [1],
            offset: ['20px', ''],
            area: ['50%', '90%'],
            content: '<?= site_url("{$this->router->class}/create") ?>/' + id
        });
    }
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
            content: '<?= site_url("{$this->router->class}/edit") ?>/' + id
        });
    }
    //删除
    function delete_row(id) {
        if (confirm('您确定要删除吗?')) {
            $.post('<?= site_url("{$this->router->class}/delete") ?>', {
                'id': id
            }, function(data) {
                if (data == 'done') {
                    location.reload();
                } else {
                    alert('操作失败!');
                }
            });
        }
    }
    //关闭
    function status_row(id, status) {
        if (status == 1) {
            $('#status1_' + id).removeClass('btn-default').addClass('btn-info');
            $('#status0_' + id).addClass('btn-default');
        } else {
            $('#status1_' + id).removeClass('btn-info').addClass('btn-default');
            $('#status0_' + id).removeClass('btn-default');
        }
        $.post('<?= site_url("{$this->router->class}/edit") ?>/' + id, {
            'status': status
        });
    }
    //二维码
    $(".qrcode").each(function() {
        var id_name = $(this).attr("id");
        var url = $(this).attr("url");
        var qrcode = new QRCode(id_name, {
            text: url,
            width: 100,
            height: 100,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    });
</script>