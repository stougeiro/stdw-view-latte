<?php declare(strict_types=1);

    namespace STDW\View\Latte;

    use STDW\Contract\ViewHandlerInterface;
    use STDW\View\Latte\Exception\ViewTemporaryDirectoryNotFoundException;
    use STDW\View\Latte\Exception\ViewFileNotFoundException;
    use Latte\Engine;


    class LatteTemplateHandler implements ViewHandlerInterface
    {
        protected Engine $latte;


        public function __construct(string $temporary_directory)
        {
            if ( ! is_dir($temporary_directory) || ! file_exists($temporary_directory)) {
                throw new ViewTemporaryDirectoryNotFoundException("View: Directory '{$temporary_directory}' not found");
            }

            $this->latte = new Engine();
            $this->latte->setTempDirectory($temporary_directory);
        }


        public function compile(string $filepath, array $data = []): string
        {
            if ( ! file_exists($filepath)) {
                throw new ViewFileNotFoundException("View: '{$filepath}' not found");
            }

            return $this->latte->renderToString($filepath, $data);
        }

        public function render(string $filepath, array $data = []): void
        {
            // if ( ! file_exists($filepath)) {
            //     throw new ViewFileNotFoundException("View: '{$filepath}' not found");
            // }

            // $this->latte->render($filepath, $data);

            echo $this->compile($filepath, $data);
        }
    }