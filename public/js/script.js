var tl = new TimelineMax({
  repeat: -1
});

var bezier = [{ x: 0, y: 0 }, { x: 0, y: 42 }, { x: 42, y: 42 }, { x: 42, y: 0 }, { x: 0, y: 0 }];

tl.staggerTo($('.wave > svg'), 0.8, { bezier: {
  type: 'thru',
  values: bezier,
  curviness: 2
}, ease: Ease.easeInOut }, 0.09);
