<template>
  <!-- <div class="scroll-snap-container" style="width : 100%; height : 100%; margin : 0; "> -->
    <div
      :class="{
        /* Custom classes */
        'dock-container': true,
        open: dockOpen,
        'menu-open': menuOpen,
      }"
      @mouseover="hovered = true /*mouse event*/"
      @mouseleave="hovered = false /*mouse event*/"
    >
      <header v-if="dockOpen">
        <span @click="toggleDock">Close</span>
      </header>
    
      <div class="stacks">
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
        <div><stack /></div>
      </div>

      <div
        :class="{
          overlay: true,
          open: showOverlay
        }"
        @click="toggleDock"
      >
        <p>Open Dock</p>
      </div>
    </div>
  <!-- </div> -->
</template>

<script>
  import {mapState} from 'vuex';
  import Stack from './Stack.vue';

  export default {
    name: 'DockContainer',
    components: {
      Stack
    },
    data() {
      return {
        dockOpen: false,
        hovered: false,
      }
    },
    computed: {
      ...mapState('menu', {
        menuOpen: state => state.open,
      }),
      showOverlay() {
        return this.hovered && !this.dockOpen;
      }
    },
    methods: {
      toggleDock() {
        this.dockOpen = !this.dockOpen;
      },
    }
  }
</script>

<style lang="scss" scoped>

.dock-container {
  position: fixed;
  right: 80px; // Dock left 
  top: calc(100vh - 120px);
  background: rgba(0,0,0,0.5);
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  box-shadow: 5px 5px 8px 5px rgba(0,0,0,0.3);
  height: 600px;
  width: calc(100% - 250px); 
  overflow: hidden;
  z-index: 1000;

  &:hover {
    top: calc(100vh - 150px);
  }

  &.menu-open {
    left: 216px;
    width: calc(100% - 232px);
  }

  &.open {
    top: calc(100vh - 600px);
  }

  .stacks {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    height: 500px;
    overflow-y: scroll;
    /*
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    */
  }
}

.overlay {
  display: none;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 150px;
  background: rgba(0,0,0,0.2);
  cursor: pointer;
  height: 150px;
  width: 100%;
  transition: all 0.2s;

  &.open {
    display: flex;
    top: 0px;
  }

  &.close {
    display: flex;
    top: 1px
  }

  p {
    color: white;
    font-weight: bold;
  }
}
</style>