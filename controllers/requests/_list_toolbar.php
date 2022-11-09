<div class="scoreboard">
    <div data-control="toolbar">
        <div class="scoreboard-item control-chart" data-control="chart-pie">
            <ul>
                <li data-color="#6a6cf7">New <span><?= $scoreboard->new_requests_count ?></span></li>
                <li data-color="#95b753">Processed <span><?= $scoreboard->processed_requests_count ?></span></li>
                <li data-color="#cc3300">Canceled <span><?= $scoreboard->canceled_requests_count ?></span></li>
            </ul>
        </div>
    </div>
</div>