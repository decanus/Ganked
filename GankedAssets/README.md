# GankedAssets

## Dependencies
- [node](https://nodejs.org/en/download/)
- [sass](http://sass-lang.com/install)
- jpegoptim ```brew install jpegoptim```
- optipng ```brew install optipng```

## Editing
Make sure your editor/IDE supports [EditorConfig](http://editorconfig.org/).

## Building

```bash
make
```

There is also a watch command available:
```bash
make watch
```

## CSS/SCSS

🚧 **These concepts are under heavy development and probably not in use everywhere.** 🚧

> Read the RSCSS guideline first: [rscss.io](http://rscss.io/)

### @extend
*@extend* is generally ONLY used with abstract classes (*%class-name*)

```scss
// abstract/placeholder-class.scss

%placeholder-class {
	color: red;
}

// components/my-component.scss
.my-component {
	@extend %placeholder-class;
}
```

### Nesting

Don't nest deeper than two levels.   
The only exception are media queries where you're allowed three levels.

```scss
.my-component {
	display: block;
	
	> .title {
		color: #fff;
	}
	
	@media screen and (orientation: landscape) {
		> .title {
			color: #000;
		}
	}
}
```

### Colors
Generally hex color codes are used. If available the short form ( e.g. #fff) is used.   
Color codes are written all lower - cased.    
If there is an opacity involved, use rgba(hex, opacity) form instead.

```scss
.my-component {
	color: #fff;
	
	> .title {
		color: rgba(#0a0a0a, .8);
	}
}
```

### Gaps 🚧
1. Gaps between block-level elements are usually given in the form of **margin-bottom**.
2. Gaps are genrally defined in **REMs (1rem = 16px)** to avoid inconsistencies between elements with diffrent font sizes.

#### Todo

- Implement **#1**