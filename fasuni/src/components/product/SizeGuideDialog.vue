<template>
  <div class="size-guide-dialog">
    <modal v-if="isOpenSizeGuideDialog" @close="$emit('update:isOpenSizeGuideDialog', false)">
      <div slot="body">
        <div class="d-flex justify-content-between header p-3 mb-3">
          <h6 class="text-uppercase mb-0">Body Measurements</h6>
          <p class="text-uppercase mb-0">
            <a :class="{'font-weight-bold': currentSizeType === sizeType.inches}" @click="currentSizeType = sizeType.inches">Inches</a>
            |
            <a :class="{'font-weight-bold': currentSizeType === sizeType.cm}" @click="currentSizeType = sizeType.cm">cm</a></p>
        </div>
        <table class="w-100 pb-3 px-2">
          <thead>
            <tr>
              <th>Size</th>
              <th>XS</th>
              <th>XS</th>
              <th>S</th>
              <th>S</th>
              <th>M</th>
              <th>M</th>
              <th>L</th>
            </tr>
          </thead>
          <tbody v-if="currentSizeType === sizeType.inches">
            <tr>
              <td>UK</td>
              <td>2</td>
              <td>4</td>
              <td>6</td>
              <td>8</td>
              <td>10</td>
              <td>12</td>
              <td>14</td>
            </tr>
            <tr>
              <td>EU</td>
              <td>30</td>
              <td>32</td>
              <td>34</td>
              <td>36</td>
              <td>38</td>
              <td>40</td>
              <td>42</td>
            </tr>
            <tr>
              <td>US</td>
              <td>00</td>
              <td>0</td>
              <td>2</td>
              <td>4</td>
              <td>6</td>
              <td>8</td>
              <td>10</td>
            </tr>
            <tr>
              <td>Bust</td>
              <td>30</td>
              <td>31</td>
              <td>32</td>
              <td>33</td>
              <td>35</td>
              <td>37</td>
              <td>39</td>
            </tr>
            <tr>
              <td>Waist</td>
              <td>23</td>
              <td>24</td>
              <td>25</td>
              <td>26</td>
              <td>28</td>
              <td>30</td>
              <td>32</td>
            </tr>
            <tr>
              <td>Hip</td>
              <td>33</td>
              <td>34</td>
              <td>35</td>
              <td>36</td>
              <td>38</td>
              <td>40</td>
              <td>42</td>
            </tr>
          </tbody>
          <tbody v-if="currentSizeType === sizeType.cm">
            <tr>
              <td>UK</td>
              <td>2</td>
              <td>4</td>
              <td>6</td>
              <td>8</td>
              <td>10</td>
              <td>12</td>
              <td>14</td>
            </tr>
            <tr>
              <td>EU</td>
              <td>30</td>
              <td>32</td>
              <td>34</td>
              <td>36</td>
              <td>38</td>
              <td>40</td>
            </tr>
            <tr>
              <td>US</td>
              <td>00</td>
              <td>0</td>
              <td>2</td>
              <td>4</td>
              <td>6</td>
              <td>8</td>
              <td>10</td>
            </tr>
            <tr>
              <td>Bust</td>
              <td>77</td>
              <td>79.5</td>
              <td>82</td>
              <td>84.5</td>
              <td>89.5</td>
              <td>94.5</td>
              <td>99.5</td>
            </tr>
            <tr>
              <td>Waist</td>
              <td>59</td>
              <td>61.5</td>
              <td>64</td>
              <td>66.5</td>
              <td>71.5</td>
              <td>76.5</td>
              <td>81.5</td>
            </tr>
            <tr>
              <td>Hip</td>
              <td>84</td>
              <td>86.5</td>
              <td>89</td>
              <td>91.5</td>
              <td>96.5</td>
              <td>101.5</td>
              <td>106.5</td>
            </tr>
          </tbody>
        </table>
      </div>
    </modal>
  </div>
</template>

<script>
import Modal from '@/components/shared/Modal';

export default {
  components: {
    Modal
  },
  props: {
    isOpenSizeGuideDialog: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      currentSizeType: 'inches',
      sizeType: {
        inches: 'inches',
        cm: 'cm'
      }
    };
  }
};
</script>

<style lang="scss">
.size-guide-dialog {
  .header {
    background-color: #f5f5f5;
  }
  table {
    text-transform: uppercase;
    font-size: .8rem;
    border-spacing: .6rem 0;
    border-collapse: separate;

    th {
      text-align: center;
      padding: 1.3rem;
      font-weight: 400;
      font-family: 'Times New Roman';
      background-color: #f5f5f5;
    }
    tbody {
      font-family: 'Futura';

      tr {
        td {
          text-align: center;
          padding: .6rem;
          background-color: #f5f5f5;
        }
        &:nth-child(odd) {
          td {
            background-color: #e6e6e6;
          }
        }
      }
    }
  }
}
</style>
