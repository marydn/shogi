<?php

declare(strict_types=1);

namespace Shogi\Command;

use Shogi\CliPrintableSpot;
use Shogi\Game;
use Shogi\Spot;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class GameCommand extends Command
{
    private const COMMANDS = ['quit'];

    protected static $defaultName = 'play:shogi';
    private OutputInterface $output;
    private Game $game;

    protected function configure()
    {
        $this->game = new Game;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $outputStyle1 = new OutputFormatterStyle('black', 'white', ['bold']);
        $outputStyle2 = new OutputFormatterStyle('white', 'blue', ['bold']);
        $outputStyle3 = new OutputFormatterStyle('black', 'yellow', ['bold', 'blink']);

        $output->getFormatter()->setStyle('white-piece', $outputStyle1);
        $output->getFormatter()->setStyle('black-piece', $outputStyle2);
        $output->getFormatter()->setStyle('illegal-move', $outputStyle3);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $error = null;

        do {
            $this->cleanScreen();
            $this->draw();

            if ($error) {
                $output->writeln(['', $error, '']);
                $error = null;
            }

            $output->writeln('<comment>To move a piece: C1xD1</comment>');
            $output->writeln('<comment>To drop a piece: drop P G1</comment>');

            $question = new Question(sprintf('<question>Turn for %s. Enter move:</question> ', $this->game->currentPlayer()));

            $nextMove = $this->getHelper('question')->ask($input, $output, $question);
            if ($nextMove) {
                $command = array_search($nextMove, self::COMMANDS);
                if (false === $command) {
                    try {
                        $this->game->currentPlayerMove($nextMove);
                    } catch (\Throwable $exception) {
                        $error = sprintf('<illegal-move>%s</>', $exception->getMessage());
                    }
                }
            }
        } while (!$this->game->hasEnded() && $nextMove !== 'quit');

        return 0;
    }

    private function arrayDecorator(array $array, $tag = 'info'): array
    {
        return array_map(function($item) use ($tag) {
            return sprintf('<%s>%s</>', $tag, $item);
        }, $array);
    }

    private function cleanScreen(): void
    {
        $this->output->write(sprintf("\033\143"));
    }

    private function draw(): void
    {
        $letters = $this->arrayDecorator(range('a', 'i'));
        $numbers = $this->arrayDecorator(range(9, 1));

        $table = new Table($this->output);
        $table->setStyle('box');
        $table->setHeaders([$numbers]);

        $positions = $this->game->positions();
        foreach ($positions as $i => $line) {
            $line = array_map(function(Spot $spot) {
                return new CliPrintableSpot($spot);
            }, $line);

            $table->addRow(array_merge($line, [$letters[$i]]));

            if ($i < count($positions) - 1) {
                $table->addRow(new TableSeparator());
            }
        }

        $table->render();

        $this->drawCaptures();
    }

    private function drawCaptures(): void
    {
        $table = new Table($this->output);
        $table->setStyle('box');
        $table->setHeaders(['Black Player Captures', 'White Player Captures']);

        $black = $this->game->blackPlayerCaptures()->toArray();
        $black = implode(' - ', $black);

        $white = $this->game->whitePlayerCaptures()->toArray();
        $white = implode(' - ', $white);

        $table->addRow([$black, $white]);
        $table->render();
    }
}