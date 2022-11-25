<template>
    <div class="container content" :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'">
        <div class="heading">
            <h1>TODO一覧</h1>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">概要</th>
                    <th scope="col">進捗</th>
                    <th scope="col">登録日</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(task, index) in tasks" :key="task.id">
                    <th scope="row">{{ task.id }}</th>
                    <td>{{ task.description }}</td>
                    <td>
                        <span class="badge badge-light" v-if="task.done === 0">未完了</span>
                        <span class="badge badge-success" v-else>完了</span>
                    </td>
                    <td>{{ getFormattedTime(task.created_at) }}</td>
                    <td>
                        <router-link v-bind:to="{ name: 'task.show', params: { taskId: task.id.toString() } }">
                            <button class="btn btn-primary">確認</button>
                        </router-link>
                    </td>
                    <td>
                        <router-link v-bind:to="{ name: 'task.edit', params: { taskId: task.id } }">
                            <button class="btn btn-success">変更</button>
                        </router-link>
                    </td>
                    <td>
                        <button class="btn btn-danger" v-on:click="deleteTask(task.id)">削除</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <ul class="pagination">
                <li class="inactive" :class="current_page == 1 ? 'disabled' : ''" @click="changePage(current_page - 1)">
                    «
                </li>
                <li @click="changePage(page)" :class="isCurrent(page) ? 'active' : 'inactive'"
                    v-for="page in frontPageRange" :key="page">
                    {{ page }}
                </li>
                <li v-show="front_dot" class="inactive disabled">...</li>
                <li @click="changePage(page)" :class="isCurrent(page) ? 'active' : 'inactive'"
                    v-for="page in middlePageRange" :key="page">
                    {{ page }}
                </li>
                <li v-show="end_dot" class="inactive disabled">...</li>
                <li @click="changePage(page)" :class="isCurrent(page) ? 'active' : 'inactive'"
                    v-for="page in endPageRange" :key="page">
                    {{ page }}
                </li>
                <li class="inactive" :class="current_page >= last_page ? 'disabled' : ''"
                    @click="changePage(current_page + 1)">
                    »
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { format } from "date-fns";
import { ja } from "date-fns/locale";

export default {
    data: function () {
        return {
            tasks: [],
            current_page: 1,
            last_page: "",
            range: 5,
            front_dot: false,
            end_dot: false,
        };
    },
    methods: {
        calRange(start, end) {
            const range = [];
            for (let i = start; i <= end; i++) {
                range.push(i);
            }
            return range;
        },
        changePage(page) {
            if (page > 0 && page <= this.last_page) {
                this.current_page = page;
                this.getTasks();
            }
        },
        getTasks() {
            axios.get(`/api/tasks?page=${this.current_page}`).then((res) => {
                const tasks = res.data;
                this.current_page = tasks.current_page;
                this.last_page = tasks.last_page;
                this.tasks = tasks.data;
            });
        },
        isCurrent(page) {
            return page === this.current_page;
        },
        deleteTask(id) {
            axios.delete("/api/tasks/" + id).then((res) => {
                this.getTasks();
            });
        },
        getFormattedTime(time) {
            if (time) {
                return format(new Date(time), "M / dd (E)", { locale: ja });
            }
        },
    },
    computed: {
        endPageRange() {
            if (!this.sizeCheck) return [];

            return this.calRange(this.last_page - 1, this.last_page);
        },
        frontPageRange() {
            if (!this.sizeCheck) {
                this.front_dot = false;
                this.end_dot = false;
                return this.calRange(1, this.last_page);
            }
            return this.calRange(1, 2);
        },
        middlePageRange() {
            let start = "";
            let end = "";

            if (!this.sizeCheck) return [];

            if (this.current_page <= this.range) {
                start = 3;
                end = this.range + 2;
                this.front_dot = false;
                this.end_dot = true;
            } else if (this.current_page > this.last_page - this.range) {
                start = this.last_page - this.range - 1;
                end = this.last_page - 2;
                this.front_dot = true;
                this.end_dot = false;
            } else {
                start = this.current_page - Math.floor(this.range / 2);
                end = this.current_page + Math.floor(this.range / 2);
                this.front_dot = true;
                this.end_dot = true;
            }
            return this.calRange(start, end);
        },
        sizeCheck() {
            if (this.last_page <= this.range + 4) {
                return false;
            }
            return true;
        },
    },
    mounted() {
        this.getTasks();
    },
};
</script>

<style>
.active {
    background-color: blue;
    color: white;
}

.disabled {
    cursor: not-allowed;
}

.inactive {
    color: #337abf;
}

.pagination {
    display: flex;
    list-style-type: none;
}

.pagination li {
    border: 1px solid #ddd;
    padding: 6px 12px;
    text-align: center;
    cursor: pointer;
}

.pagination li+li {
    border-left: none;
}
</style>
