const state = {
    contentMinHeight: 0,
};

const getters = {
    getContentMinHeight: (state) => state.contentMinHeight,
};

const mutations = {
    calcHeaderHeightMutations(state, payload) {
        state.contentMinHeight = payload.windowInnerHeight - payload.headerHeight;
    },
};

const actions = {
    calcHeaderHeightActions(store, payload) {
        store.commit("calcHeaderHeightMutations", payload);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
