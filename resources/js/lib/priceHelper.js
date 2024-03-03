export class PriceHelper {
    constructor(priceObj) {
        this.options = priceObj.options;
        this.materials = priceObj.materials;
    }

    isInSet(set, value) {
        let range = set.split('-')
        if (range[1] === '') range[1] = Number.MAX_SAFE_INTEGER
        return parseInt(value) >= parseInt(range[0]) && parseInt(value) <= parseInt(range[1])
    }

    getNumberOfSheetsIndex(inputNumber) {
        for (const range in this.printCost) {
          const [min, max] = range.split('-').map(Number);
          
          if (min <= inputNumber && (max === 0 || inputNumber <= max)) {
            return this.printCost[range];
          }
        }
        return 0;
    }

    // getItemsPerListIndex(count) {
    //     let self = this
    //     if (!count) return 0;
    //     return parseFloat(Object.entries(this.itemsPerListIndex).filter(function (item) {
    //         return self.isInSet(item[0], count)
    //     }));
    // }

    // getItemsPerListIndex(inputNumber) {
    //     console.log(inputNumber)
    //     for (const range in this.itemsPerListIndex) {
    //       const [min, max] = range.split('-').map(Number);
    //       if (min <= inputNumber && (max === 0 || inputNumber <= max)) {
    //         return this.itemsPerListIndex[range];
    //       }
    //     }
    //     return 0;
    // }
    
    getValueBetweenKeys(object, number) {
      const keys = Object.keys(object).sort((a, b) => Number(a) - Number(b)); // Sort keys numerically
      for (let i = 0; i < keys.length; i++) {
        const currentKey = Number(keys[i]);
        const nextKey = Number(keys[i + 1]);
        if (keys.length - 1 == i || number >= currentKey && number < nextKey) {
          return object[keys[i]]; // Return the value corresponding to the current key
        }
      }
    
      return null; // If number doesn't fall within any key range
    }

    getPrice({numberOfSheets, numberOfItemsPerList} = {}, material, matglanec) {
      let getMatGlanec = () => {
        if(matglanec) {
          return this.getValueBetweenKeys(material.mat_glanec_covering, numberOfSheets)[matglanec.indx - 1];
        }
        return 0;
      }
      this.price = numberOfSheets
       * (this.getValueBetweenKeys(material.cost_printing, numberOfSheets)
       + (this.getValueBetweenKeys(material.cost_cut, numberOfSheets) 
       * this.getValueBetweenKeys(material.quantity_factor, numberOfItemsPerList)
       + getMatGlanec()) 
       + (Number(this.options.euroCurrency) * material.material_price ))

      //  console.log(
      //   numberOfSheets
      //   ,this.getValueBetweenKeys(material.cost_printing, numberOfSheets)
      //   ,this.getValueBetweenKeys(material.cost_cut, numberOfSheets) 
      //   ,this.getValueBetweenKeys(material.quantity_factor, numberOfItemsPerList)
      //   ,getMatGlanec() 
      //   ,Number(this.options.euroCurrency) 
      //   ,material.material_price )
       return this.price;
    }

    moneyFormatter(days) {
      return this.getValueBetweenKeys(this.options.speedIndex, days)
    }
}
