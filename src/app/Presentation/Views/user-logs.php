<style>
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    table tr th,
    table tr td {
        border: 1px #eee solid;
        padding: 5px;
    }
</style>
<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Action</th>
            <th>Log time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userLogs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['user_id']) ?></td>
                <td><?= htmlspecialchars($log['action']) ?></td>
                <td><?= htmlspecialchars($log['log_time']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>