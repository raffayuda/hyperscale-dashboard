export type ClickOutsideHandler = () => void;

export function clickOutside(node: HTMLElement, handler: ClickOutsideHandler) {
    let currentHandler = handler;

    const handleClick = (event: MouseEvent) => {
        if (!node.contains(event.target as Node)) {
            currentHandler?.();
        }
    };

    document.addEventListener('click', handleClick, true);

    return {
        update(newHandler: ClickOutsideHandler) {
            currentHandler = newHandler;
        },
        destroy() {
            document.removeEventListener('click', handleClick, true);
        }
    };
}

