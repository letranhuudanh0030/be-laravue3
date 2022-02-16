import tooltipDirective from './Tooltip/'
import clickoutsideDirective from './Clickoutside/'

// register all directives
const directives = (app) => {
    tooltipDirective(app),
    clickoutsideDirective(app)
}

export default directives
