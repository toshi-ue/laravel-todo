<template>
    <!-- <div class="container content" :style="'min-height: ' + $store.state.rect.contentMinHeight + 'px'"> -->
    <div class="container content">
        <!-- TODO: フラッシュメッセージを追加する -->
        <div class="heading row mt-4">
            <div class="col-8">
                <h1>TODO一覧</h1>
            </div>
            <div class="col d-flex align-items-center justify-content-end">
                <RouterLink v-bind:to="{ name: 'task.new' }">
                    <button class="btn btn-success">追加</button>
                </RouterLink>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right">
                <label for="display-count">表示件数</label>
                <select name="per-page" id="display-count" v-model="perPage" v-bind:checked="perPage"
                    v-on:change="changePerPage">
                    <option value="1">1</option>
                    <option value="10">10</option>
                    <option value="20">20</option>

                </select>
            </div>
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
                <tr v-for="task in tasks" :key="task.id">
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
        <div v-if="getPageCount > 1">
            <VuejsPaginate v-model="currentPage" :pageCount="getPageCount" :prevText="'<'" :nextText="'>'"
                :clickHandler="paginateClickCallback" :containerClass="'pagination'" :first-last-button="true"
                :first-button-text="'<<'" :last-button-text="'>>'" :pageClass="'page-item'">
            </VuejsPaginate>
        </div>
    </div>
</template>

<script>
import VueJsPaginate from "vuejs-paginate";
import { format } from "date-fns";
import { ja } from "date-fns/locale";

const FIRST_PAGE_NUMBER = 1;
const DEFAULT_PER_PAGE = "10";

export default {
    components: {
        'VuejsPaginate': VueJsPaginate
    },
    data: function () {
        return {
            tasks: [],
            currentPage: this.currentPage = this.$route.query.page || FIRST_PAGE_NUMBER,
            perPage: this.perPage = this.$route.query.perPage || DEFAULT_PER_PAGE,
            // QUESTION 初期値は null 0 のどちらが良いのか?
            totalCount: 0,
        };
    },
    methods: {
        getTasks() {
            axios.get(`/api/tasks`, { params: { perPage: this.perPage, page: this.currentPage } }).then((res) => {
                const result = res.data;
                this.tasks = result.data;
                this.currentPage = result.current_page;
                this.perPage = result.per_page;
                this.totalCount = result.total;
            });
        },
        deleteTask(id) {
            axios.delete("/api/tasks/" + id).then((res) => {
                this.getTasks();
            });
        },
        paginateClickCallback: function (pageNum) {
            this.currentPage = pageNum;
            this.$router.push({ name: 'tasks', query: { perPage: this.perPage, page: this.currentPage, } })
        },
        changePerPage(e) {
            // QUESTION 不正な値の挿入は気にしなくて良い?
            //  [Laravel5のページング機能に表示件数の可変を実装する方法 - Qiita](https://qiita.com/qwe001/items/a82054b45acaca164d7c)
            const changedPerPage = e.target.value;
            if (["1", "10", "20"].includes(changedPerPage)) {
                this.perPage = changedPerPage;
            } else {
                this.perPage = DEFAULT_PER_PAGE;
            }
            this.currentPage = 1;
            this.$router.push({ name: 'tasks', query: { perPage: this.perPage, page: this.currentPage, } })

        },
        getFormattedTime(time) {
            if (time) {
                return format(new Date(time), "M / dd (E)", { locale: ja });
            }
        },
    },
    beforeRouteUpdate(to, from, next) {
        // UGLY: next()を実行しないとqueryの値が更新されない
        // [【Nuxt.js/Vue.js】<nuxt-link>や$router.pushで同じパスに遷移すると画面が更新されない](https://zenn.dev/kokota/articles/352ecf9ada3a48)
        next();
        this.getTasks(to.query.perPage, to.query.page);
    },
    computed: {
        getPageCount: function () {
            return Math.ceil(this.totalCount / this.perPage);
        }
    },
    mounted() {
        this.getTasks(FIRST_PAGE_NUMBER);
    },
};
</script>

<style>
.active {
    background-color: blue;
    color: white;
}

.inactive {
    color: #337abc;
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

.pagination li.disabled,
.pagination li.disabled a,
.page-item.disabled,
.page-item.disabled a {
    color: #616A71;
    opacity: .5;
    cursor: not-allowed;
}


.pagination li+li {
    border-left: none;
}
</style>
