<template>
    <div
      :class="{
        'dock-container': true,
        open: dockOpen,

      }"
      @mouseover="hovered = true"
      @mouseleave="hovered = false"
    >
      <header>
        <span @click="toggleDock">Close</span>
      </header>
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
</template>

<script>
  export default {
    name: 'DockContainer',
    data() {
      return {
        dockOpen: false,
        hovered: false,
      }
    },
    computed: {
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
  left: 80px;
  top: calc(100vh - 120px);
  background: rgba(0,0,0,0.5);
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
  box-shadow: 5px 5px 8px 5px rgba(0,0,0,0.3);
  height: 600px;
  width: calc(100% - 96px);
  overflow: hidden;
  z-index: 1000;

  &:hover {
    top: calc(100vh - 150px);
  }

  &.open {
    top: calc(100vh - 600px);
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

  p {
    color: white;
    font-weight: bold;
  }
}
</style>