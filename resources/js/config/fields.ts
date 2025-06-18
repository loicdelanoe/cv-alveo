interface Fields {
  validation: {
    [key: string]: string[]
  }
}

export const fields: Fields = {
  validation: {
    text: ['string'],
    textarea: ['string'],
    checkbox: ['boolean'],
    radio: ['string'],
    select: ['string'],
    file: ['file'],
    date: ['date'],
    time: ['time'],
    datetime: ['date'],
    color: ['string'],
    repeater: ['array'],
    // image: ['file', 'image'],
  },
}
